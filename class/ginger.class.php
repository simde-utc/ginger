<?php
require_once 'ApiException.class.php';
require_once 'AccountsApi.class.php';

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
		
		// Si l'utilisateur est introuvable, on essaie de le récupérer à la DSI
		if(!$personne){
			$personneData = AccountsApi::getUserInfo($login);
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
		
		$retour = array(
				"login" => $personne->getLogin(),
				"nom" => $personne->getNom(),
				"prenom" => $personne->getPrenom(),
				"mail" => $personne->getMail(),
				"type" => $personne->getType(),
				"is_adulte" => $personne->getIsAdulte(),
				"is_cotisant" => $personne->isCotisant()
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

