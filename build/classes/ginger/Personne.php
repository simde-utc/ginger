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
		// Le personnel est membres d'honneur
		if($this->getType() == "pers") {
			return true;
		}
		
		$crit = new Criteria();
		$crit->add(CotisationPeer::DEBUT, Criteria::CURRENT_DATE, Criteria::LESS_EQUAL);
		$crit->add(CotisationPeer::FIN, Criteria::CURRENT_DATE, Criteria::GREATER_EQUAL);
		$crit->add(CotisationPeer::DELETED_AT, NULL ,Criteria::ISNULL);
		
		return !$this->getCotisations($crit)->isEmpty();
	}
	
	public function updateFromAccounts($accounts) {
		if($this->getLogin()){
			$personneData = $accounts->getUserInfo($this->getLogin());
		}
		
		if($personneData){
			$this->setLogin($personneData->username);
			$prenom = preg_replace("/(\s+|-)(\w)/ue", "'\\1'.mb_strtoupper('\\2')", mb_strtolower($personneData->firstName));
			$this->setPrenom(preg_replace("/^(\w)/ue", "mb_strtoupper('\\1')", $prenom));
			$this->setNom(mb_strtoupper($personneData->lastName));
			$this->setMail($personneData->mail);
			switch($personneData->profile){
				case "ETU UTC":
					$this->setType("etu");
					break;
				case "ETU ESCOM":
					$this->setType("escom");
					break;
				case "PERSONNEL":
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
			
			return true;
		}
		return false;
	}
}
