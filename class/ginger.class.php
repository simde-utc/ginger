<?php
require_once 'ApiException.class.php';

class Ginger {
	protected $auth;
	
	public function __construct($key) {
		if (empty($key)) {
			throw new Exception("You need a key bastard !!");
		}
		$this->auth = AuthkeyQuery::create()
						->filterByCle($key)
            ->findOne();
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
		
		if($this->auth->getDroitBadges())

		if ($this->auth->getDroits() == "etendu") {
			return $personne->getDetailsEtendu();
		}
		else {
			return $personne->getDetailsSimple();
		}
	}

	public function findPersonne($loginPart) {
		return Personne::find($loginPart);
	}
}

