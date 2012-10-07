<?php
require_once 'ApiException.class.php';

class Ginger {
	protected $auth;
	
	public function __construct($key) {
		// vérification que la clef est en argument
		if (empty($key))
			throw new ApiException(401);

		// vérification que la clef est dans la base
		$this->auth = AuthkeyQuery::create()->findOneByCle($key);
		if(!$this->auth)
			throw new ApiException(403);
	}

	public function getPersonneDetails($login) {
		// récupération de la personne
		$personne = PersonneQuery::create()->findOneByLogin($login);
		if(!$personne)
			throw new ApiException(404);

		// création de l'array du retour
		$retour = array(
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
			$badge = array_merge($retour, $badge);
		}

		return $retour;
	}

	public function getPersonneCotisations($login) {
		// TODO Auth
		$personne = PersonneQuery::create()->findOneByLogin($login);
		if(!$personne)
			throw new ApiException(404);

		$cotisations = $personne->getCotisations();
		$r = array();
		foreach($cotisations as $cotisation) {
			$r[] = $cotisation->toJSON();
		}
		return $r;
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

