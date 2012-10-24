<?php
require_once 'Koala.class.php';
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
						->_if($this->auth->getDroitBadges())
						->orWhere("p.badgeUid = ?", $login)
						->_endif()
						->findOneOrCreate();
		
		// Si l'utilisateur est introuvable, on essaie de le récupérer à la DSI
		if($personne->isNew()){
			// On cherche à mettre à jour en utilisant le login
			$personne->updateFromAccounts($this->accounts);
			
			// Si l'utilisateur est toujours introuvable et qu'on a les droits, on recherche le badge
			if($personne->isNew() && $this->auth->getDroitBadges()){
				$personneData = $this->accounts->cardLookup($login);
				
				if(!empty($personneData->username)){
					$personne = PersonneQuery::create()
									->filterByLogin($personneData->username)
									->findOneOrCreate();
					$personne->setBadgeUid($personneData->cardSerialNumber);
					$personne->save();
				}
			}
		}
		
		// S'il est toujours introuvable, on renvoie une erreur
		if($personne->isNew())
			throw new ApiException(404);
		
		// On a la personne, bien. On met quand même à jour si :
		// - il est mineur
		// - on n'a pas son mail (import depuis le fichier des cotisants)
		if(!$personne->getIsAdulte() || !$personne->getMail()){
			$personne->updateFromAccounts($this->accounts);
		}

		// création de l'array du retour
		$retour = array(
				"login" => $personne->getLogin(),
				"nom" => $personne->getNom(),
				"prenom" => $personne->getPrenom(),
				"mail" => $personne->getMail(),
				"type" => $personne->getType(),
				"is_adulte" => $personne->getIsAdulte(),
				"is_cotisant" => $personne->isCotisant()
		);

		// si la personne a les droits badges, alors on envoie aussi les badges
		if($this->auth->getDroitBadges()){
			$badge = array(
					"badge_uid" => $personne->getBadgeUid(),
					"expiration_badge" => $personne->getExpirationBadge()
			);
			$retour = array_merge($retour, $badge);
		}

		return $retour;
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
			$r[] = array(
				"debut" => $cotisation->getDebut(),
				"fin" => $cotisation->getFin(),		
				"montant" => $cotisation->getMontant(),
			);
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
}

