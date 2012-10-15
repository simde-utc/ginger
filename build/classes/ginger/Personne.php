<?php



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
	
	public function isCotisant()
	{
		$crit = new Criteria();
		$crit->add(CotisationPeer::DEBUT, Criteria::CURRENT_DATE, Criteria::LESS_EQUAL);
		$crit->add(CotisationPeer::FIN, Criteria::CURRENT_DATE, Criteria::GREATER_EQUAL);
		
		return !$this->getCotisations($crit)->isEmpty();
	}
	
	public function updateFromAccounts(){
		if($this->getLogin()){
			$personneData = AccountsApi::getUserInfo($this->getLogin());
		}
		if(!$personneData && $this->getBadgeUid()){
			$personneData = AccountsApi::cardLookup($this->getBadgeUid());
		}
		
		if($personneData){
			$this->setLogin($personneData->username);
			$this->setPrenom(ucfirst(preg_replace("/(\s+|-)(\w)/e","'\\1' . strtoupper('\\2')",strtolower($personneData->firstName))));
			$this->setNom(strtoupper($personneData->lastName));
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
			
			// Si c'est un personnel, il est membre d'honneur
			if($this->getType() == "pers" && !$this->isCotisant()){
				// Calcul des dates de la cotisation
				$debut = date("Y-m-d");
				$yearend = date("Y");
				if(date("m") > 8) $yearend++;
				$fin = "$yearend-08-31";
        
				// création de la nouvelle cotisation
				$cotisation = new Cotisation();
				$cotisation->setDebut($debut);
				$cotisation->setFin($fin);
				$cotisation->setPersonne($this);
				$cotisation->setMontant(0);
				$cotisation->save();
			}
			return true;
		}
		return false;
	}
}
