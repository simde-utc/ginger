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
		$crit->add(CotisationPeer::DEBUT, Criteria::CURRENT_DATE, Criteria::LESS_THAN);
		$crit->add(CotisationPeer::FIN, Criteria::CURRENT_DATE, Criteria::GREATER_THAN);
		
		return !$this->getCotisations($crit)->isEmpty();
	}
}
