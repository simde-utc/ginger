<?php
require_once '../lib/Koala/Koala.class.php';
use \Koala\ApiException;

require_once 'AccountsApi.class.php';

class Ginger {
	protected $auth, $accounts;
	
	public function __construct($accounts_url, $key) {
		// vérification que la clef est en argument
		if (empty($key))
			throw new ApiException(401);

		// vérification que la clef est dans la base
		$this->auth = AuthkeyQuery::create()->findOneByCle($key);
		if(!$this->auth)
			throw new ApiException(403);

        // Initialisation de Accounts
		$this->accounts = new AccountsApi(Config::$ACCOUNTS_URL);
	}

	public function getPersonneDetails($login) {
		// récupération de la personne
		$personne = PersonneQuery::create('p')
						->where("p.login = ?", $login)
						->findOneOrCreate();
		
		// Si l'utilisateur est introuvable, on essaie de le récupérer à la DSI
		// On récupère aussi si il est mineur ou qu'on n'a pas son mail (importé des cotisants)
		if($personne->isNew() || !$personne->getIsAdulte() || !$personne->getMail()){
			// On cherche à mettre à jour en utilisant le login
			$personne->updateFromAccountsWithLogin($this->accounts);
		}
		
		// S'il est toujours neuf (pas trouvé ni sauvé par un updateFromAccounts)
		if($personne->isNew()){
			throw new ApiException(404);
		}

		return $personne->getArray($this->auth->getDroitBadges());
	}
	
	public function getPersonneDetailsByCard($card) {
		// Vérification des droits
		if(!$this->auth->getDroitBadges())
			throw new ApiException(403);
		
		// Récupération de la personne
		$personne = PersonneQuery::create('p')
						->where("p.badgeUid = ?", $card)
						->findOne();
		
		// Si l'utilisateur est introuvable, on essaie de le trouver via la DSI
		if(!$personne){
			// On cherche la personne par carte
			$accountsData = $this->accounts->cardLookup($card);
			
			// Si la DSI ne renvoie rien, il n'existe pas
			if(!$accountsData)
				throw new ApiException(404);
			
			// Il existe, on recherche son login dans ginger (ou on lui fait une nouvelle ligne)
			$personne = PersonneQuery::create('p')
							->where("p.login = ?", $accountsData->username)
							->findOneOrCreate();
			
			// On met à jour toutes les données (notamment le badge) avec ce qu'on a déjà récupéré
			$personne->updateFromAccounts($accountsData);
		}
		// S'il existe mais est mineur ou qu'on n'a pas son mail (importé des cotisants)
		else if(!$personne->getIsAdulte() || !$personne->getMail()){
			$personne->updateFromAccountsWithCard($this->accounts);
		}

		return $personne->getArray($this->auth->getDroitBadges());;
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
}

