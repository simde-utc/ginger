<?php
require_once '../lib/Koala/Koala.class.php';
use \Koala\ApiException;

require_once 'AccountsApi.class.php';
require_once 'GingerAccountsApi.class.php';

class Ginger {
	protected $auth, $accounts;
	
	public function __construct($key) {
		// vérification que la clef est en argument
		if (empty($key))
			throw new ApiException(401);

		// vérification que la clef est dans la base
		$this->auth = AuthkeyQuery::create()->findOneByCle($key);
		if(!$this->auth)
			throw new ApiException(403);

		// Initialisation de Accounts
		if (Config::$ACCOUNTS_BACKEND === 'ginger') {
			$this->accounts = new GingerAccountsApi(Config::$ACCOUNTS_URL, Config::$REMOTE_GINGER_KEY,
			Config::$REMOTE_GINGER_TIMEOUT);
		}
		else {
			$this->accounts = new AccountsApi(Config::$ACCOUNTS_URL);
		}
	}

	public function getPersonneDetails($login) {
		// récupération de la personne
		$personne = PersonneQuery::create('p')
						->where("p.login = ?", $login)
						->findOneOrCreate();
		
		if (($personne->getType() != "ext" && Config::$REFRESH_ON_LOGIN_LOOKUP) || $personne->isNew()) {
            try {
                // On cherche à mettre à jour en utilisant le login
                $personne->updateFromAccountsWithLogin($this->accounts);	  
            }
            catch (AccountsApiException $ex){
                // Le login ne correspond à personne, 404
                if(substr($ex->getMessage(), 0, 20) == "No person with login"){
                    throw new ApiException(404);
                }
                error_log(substr("$ex", 0 , 120));
            }
            catch (AccountsNetworkException $ex){
                // Ok, too bad
                error_log(substr("$ex", 0, 120));
            }
        }
		
		// Si on a toujours un objet vide, il n'existe pas
		if($personne->isNew()){
			throw new ApiException(404);
		}

		return $personne->getArray($this->auth->getDroitBadges());
	}

	public function getPersonneDetailsByCard($card) {
		// Vérification des droits
		if(!$this->auth->getDroitBadges())
			throw new ApiException(403);

		$personne = PersonneQuery::create('p')->where("p.badgeUid = ?", $card)->findOne();

		if (!$personne || (Config::$REFRESH_ON_CARD_LOOKUP && $personne->getType() != "ext")) {
			try {
				// On cherche la personne par carte
				$accountsData = $this->accounts->cardLookup($card);

				// Si on a une réponse d'Accounts, on met à jour à partir de cette réponse
				if($accountsData && $accountsData->username){
					// On recherche dans Ginger à partir du login (ou on fait une nouvelle ligne)
					$personne = PersonneQuery::create('p')
									->where("p.login = ?", $accountsData->username)
									->findOneOrCreate();
			
					// On met à jour toutes les données (notamment le badge) avec ce qu'on a déjà récupéré
					$personne->updateFromAccounts($accountsData);				
				}
			}
			catch(AccountsApiException $ex) {
				// Le badge ne correspond à personne, 404
				if(substr($ex->getMessage(), 0, 33) == "No badge found with serial number"){
					throw new ApiException(404);
				}
				error_log(substr("$ex", 0 , 120));
			}
			catch(AccountsNetworkException $ex){
				// Erreur réseau, skip
				error_log(substr("$ex", 0 , 120));
			}
		}

		// Si $personne est toujours vide (Accounts n'a rien renvoyé, ou Accounts down et pas dans Ginger)
		if(!$personne || $personne->isNew()) {
			throw new ApiException(404);
		}

		return $personne->getArray($this->auth->getDroitBadges());
	}

	public function getPersonneCotisations($login) {
		// Vérification des droits
		if(!$this->auth->getDroitCotisations())
			throw new ApiException(403);
			
		$personne = PersonneQuery::create()->findOneByLogin($login);
		if(!$personne)
			throw new ApiException(404);

		$cotisations = $personne->getCotisations();
		
		$r = array();
		foreach($cotisations as $cotisation) {
			$cot = array(
				"id" => $cotisation->getId(),
				"debut" => $cotisation->getDebut(),
				"fin" => $cotisation->getFin(),		
				"montant" => $cotisation->getMontant(),
			);
			if ($cotisation->getDeletedAt()) {
				$cot["deleted_at"] = $cotisation->getDeletedAt();
			}
			$r[] = $cot;
		}
		return $r;
	}

	public function findPersonne($loginPart) {
 	 	$q = PersonneQuery::create();
 	 	$personnes = $q->filterByLogin("%$loginPart%")
 	 	               ->_or()
 	 	               ->filterByNom("%$loginPart%")
 	 	               ->_or()
 	 	               ->filterByPrenom("%$loginPart%")
 	 	               ->orderByLogin()
 	 	               ->limit(10)
 	 	               ->find();

 	 	$liste = array();
 	 	foreach ($personnes as $personne) {
 	 	 	$liste[] = array('login' => $personne->getLogin(),
 	 	 	                 'nom' => $personne->getNom(),
 	 	 	                 'prenom' => $personne->getPrenom());
 	 	}

		return $liste;
	}

	public function addCotisation($login, $debut, $fin, $montant) {
		// vérification des droits en écriture et accès aux cotisations
		if(!$this->auth->getDroitEcriture() || !$this->auth->getDroitCotisations())
			throw new ApiException(403);

		// récupération de la personne concernée
		$personne = PersonneQuery::create()
						->findOneByLogin($login);
		if(!$personne)
			throw new ApiException(404);
		
		// On récupère toutes les cotisations de ce user
		$cotisations = $personne->getCotisations();
		
		// Si une de ces cotisations englobe la nouvelle cotisation, on la refuse
		foreach($cotisations as $cotisation) {
			if($debut >= strtotime($cotisation->getDebut())
			  && $fin <= strtotime($cotisation->getFin())
			  && !$cotisation->getDeletedAt()){
				throw new ApiException(409);
			}
		}

		// création de la nouvelle cotisation
		$cotisation = new Cotisation();
		$cotisation->setDebut($debut);
		$cotisation->setFin($fin);
		$cotisation->setPersonne($personne);
		$cotisation->setMontant($montant);
		// sauvegarde
		$cotisation->save();

		return $cotisation->getid();
	}

	public function deleteCotisation($id_cotisation) {
		// check les droits
		if(!$this->auth->getDroitEcriture() || !$this->auth->getDroitCotisations())
			throw new ApiException(403);

		// récupérer la cotisation
		$cotisation = CotisationQuery::create()
						->findPk($id_cotisation);
		
		// si elle n'existe pas on lance une 404
		if(!$cotisation)
			throw new ApiException(404);

		// sinon on la detruit
		$cotisation->delete();
		
		return True;
	}
  
  public function getStats(){
		if(!$this->auth->getDroitCotisations())
			throw new ApiException(403);
    
    $semestres = CotisationQuery::create()
      ->withColumn("COUNT(*)", "Count")
      ->groupByDebut()
      ->orderByDebut()
      ->find();

    $output = array();
    foreach($semestres as $semestre){
      if(isset($output[$this->dateToSemestre($semestre->getDebut())])){
        $output[$this->dateToSemestre($semestre->getDebut())] += $semestre->getCount();
      }
      else {
        $output[$this->dateToSemestre($semestre->getDebut())] = $semestre->getCount();
      }
    }
    
    return $output;
  }
  
  public function setPersonne($login, $prenom, $nom, $mail, $is_adulte) {
	// check les droits
	if(!$this->auth->getDroitEcriture())
		throw new ApiException(403);

	// récupération de la personne concernée
	$personne = PersonneQuery::create()
					->findOneByLogin($login);
	if(!$personne)
		throw new ApiException(404);

	$personne->updateFromUser($prenom, $nom, $mail, $is_adulte);

	return $personne->getArray($this->auth->getDroitBadges());
  }

  protected function dateToSemestre($date){
    $time = strtotime($date);

    if(date('m', $time) == 1) {
      return 'A'.(date('y', $time)-1);
    }
    else if(date('m', $time) >= 2 && date('m', $time) <= 7) {
      return 'P'.date('y', $time);
    }	
    elseif(date('m', $time) >= 8) {
      return 'A'.date('y', $time);
    }
    else {
      return 'WTF ?';
    }
  }
}

