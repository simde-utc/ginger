<?php

require_once 'class/Auth.class.php';
require_once 'models/Personne.class.php';

class Ginger {
	protected $auth;
	
	public function __construct($key) {
		if (empty($key)) {
			throw new Exception("You need a key bastard !!");
		}
		$auth = Auth::getInstance();
		$auth->login($key);
		$this->auth = $auth;
	}

	public function getPersonneDetails($login) {
		$personne = new Personne($login);
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

