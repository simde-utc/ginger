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
}

