<?php
require_once 'ApiException.class.php';
require_once 'AccountsApi.class.php';

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
		$personne = PersonneQuery::create('p')
						->where("p.login = ?", $login)
						->_if($this->auth->getDroitBadges())
						->orWhere("p.badgeUid = ?", $login)
						->_endif()
						->findOne();
		
		// Si l'utilisateur est introuvable, on essaie de le récupérer à la DSI
		if(!$personne){
			$personneData = AccountsApi::getUserInfo($login);
			
			// S'il a les droits sur les badges, on essaie aussi avec l'id de badge
			if(!$personneData && $this->auth->getDroitBadges()){
				$personneData = AccountsApi::cardLookup($login);
			}
			
			if($personneData){
				$personne = new Personne();
				$personne->setLogin($personneData->username);
				$personne->setPrenom(ucfirst(strtolower($personneData->firstName)));
				$personne->setNom(strtoupper($personneData->lastName));
				$personne->setMail($personneData->mail);
				switch($personneData->profile){
					case "ETU UTC":
						$personne->setType("etu");
						break;
					case "ETU ESCOM":
						$personne->setType("escom");
						break;
					case "PERSONNEL":
						$personne->setType("pers");
						break;
					case "PERSONNEL ESCOM": // Purement théorique pour l'instant
					$personne->setType("escompers");
						break;
				}
				$personne->setBadgeUid($personneData->cardSerialNumber);
				$personne->setExpirationBadge($personneData->cardEndDate/1000);
				$personne->setIsAdulte($personneData->legalAge);
				$personne->save();
			}
		}
		
		// S'il est toujours introuvable, on renvoie une erreur
		if(!$personne)
			throw new ApiException(404);

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

