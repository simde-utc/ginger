<?php

mb_internal_encoding("UTF-8");

/**
 * Skeleton subclass for representing a row from the 'personne' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.ginger
 */
class Personne extends BasePersonne
{

	public function isCotisant() {
		// Le personnel doit faire sa demande auprès du BDE pour être inscrit sur les listes
		// // Le personnel est membres d'honneur
		// if($this->getType() == "pers") {
		// 	return true;
		// }

		$crit = new Criteria();
		$crit->add(CotisationPeer::DEBUT, Criteria::CURRENT_DATE, Criteria::LESS_EQUAL);
		$crit->add(CotisationPeer::FIN, Criteria::CURRENT_DATE, Criteria::GREATER_EQUAL);
		$crit->add(CotisationPeer::DELETED_AT, NULL ,Criteria::ISNULL);

		return !$this->getCotisations($crit)->isEmpty();
	}

	public function updateFromUser($prenom, $nom, $mail, $is_adulte) {
		$this->setPrenom($prenom);
		$this->setNom($nom);
		$this->setMail($mail);
		$this->setIsAdulte($is_adulte);

		$this->save();
	}

	public function updateFromAccounts($personneData){
		$this->setLogin($personneData->username);
		$prenom = preg_replace("/(\s+|-)(\w)/ue", "'\\1'.mb_strtoupper('\\2')", mb_strtolower($personneData->firstName));
		$this->setPrenom(preg_replace("/^(\w)/ue", "mb_strtoupper('\\1')", $prenom));
		$this->setNom(mb_strtoupper($personneData->lastName));
		$this->setMail($personneData->mail);
		switch($personneData->profile){
			case "ETU UTC":
				$this->setType("etu");
				break;
			case "ESCOM ETU":
				$this->setType("escom");
				break;
			case "PERSONNEL UTC":
				$this->setType("pers");
				break;
			case "PERSONNEL ESCOM": // Purement théorique pour l'instant
			$this->setType("escompers");
				break;
		}
		$this->setBadgeUid($personneData->cardSerialNumber);
		$this->setExpirationBadge($personneData->cardEndDate/1000);
		$this->setIsAdulte($personneData->legalAge);
		$this->save();
	}

	public function updateFromAccountsWithLogin($accounts){
		$accountsData = $accounts->getUserInfo($this->getLogin());
		if($accountsData){
			$this->updateFromAccounts($accountsData);
		}
	}

	public function updateFromAccountsWithCard($accounts){
		$accountsData = $accounts->cardLookup($this->getBadgeUid());
		if($accountsData){
			$this->updateFromAccounts($accountsData);
		}
	}

	public function getArray($badgeData) {
		// création de l'array du retour
		$retour = array(
				"login" => $this->getLogin(),
				"nom" => $this->getNom(),
				"prenom" => $this->getPrenom(),
				"mail" => $this->getMail(),
				"type" => $this->getType(),
				"is_adulte" => $this->getIsAdulte(),
				"is_cotisant" => $this->isCotisant()
		);

		// si la personne a les droits badges, alors on envoie aussi les badges
		if($badgeData){
			$badge = array(
					"badge_uid" => $this->getBadgeUid(),
					"expiration_badge" => $this->getExpirationBadge()
			);

			$retour = array_merge($retour, $badge);
		}

		return $retour;
	}
}
