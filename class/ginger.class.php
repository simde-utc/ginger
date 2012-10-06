<?php
require_once 'ApiException.class.php';

class Ginger {
	protected $auth;
	
	public function __construct($key) {
		if (empty($key)) {
			throw new ApiException(401);
		}
		
		$this->auth = AuthkeyQuery::create()
            ->findOneByCle($key);
		
		if(!$this->auth)
			throw new ApiException(403);
	}

	public function getPersonneDetails($login) {
		$personne = PersonneQuery::create()
						->findOneByLogin($login);
		
		if(!$personne)
			throw new ApiException(404);
		
		$retour = array(
				"nom" => $personne->getNom(),
				"prenom" => $personne->getPrenom(),
				"mail" => $personne->getMail(),
				"type" => $personne->getType(),
				"is_adulte" => $personne->getIsAdulte()
		);
		
		if($this->auth->getDroitBadges()){
			$badge = array(
					"badge_uid" => $personne->getBadgeUid(),
					"expiration_badge" => $personne->getExpirationBadge()
			);
			$badge = array_merge($retour, $badge);
		}

		return $retour;
	}

	public function findPersonne($loginPart) {
		return Personne::find($loginPart);
	}

	public function addCotisation($login, $debut, $fin) {
		// vérification des droits en écriture
		if(!$this->auth->getDroitEcriture())
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
		// sauvegarde
		$cotisation->save();

		return $cotisation->getid();
	}
}

