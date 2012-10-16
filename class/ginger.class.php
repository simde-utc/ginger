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
						->findOne();
		
		// Si l'utilisateur est introuvable, on essaie de le récupérer à la DSI
		if(!$personne){
			// On créé un nouvel objet
			$newpersonne = new Personne();
			
			// On essaie de set le login
			$newpersonne->setLogin($login);
			
			// Si l'utilisateur a le droit, on essaie de set le badge aussi
			if($this->auth->getDroitBadges()){
				$newpersonne->setBadgeUid($login);
			}

			// Si l'update a réussi, on garde l'objet
			if($newpersonne->updateFromAccounts($this->accounts)){
				$personne = $newpersonne;
				$personne->save();
			}
		}
		
		// S'il est toujours introuvable, on renvoie une erreur
		if(!$personne)
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
			);
		}
		return $r;
	}

	public function findPersonne($loginPart) {
		return Personne::find($loginPart);
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

