<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entities\Authkey
 */
class Authkey
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $asso
     */
    private $asso;

    /**
     * @var string $details
     */
    private $details;

    /**
     * @var string $cle
     */
    private $cle;

    /**
     * @var boolean $droitEcriture
     */
    private $droitEcriture;

    /**
     * @var boolean $droitBadges
     */
    private $droitBadges;

    /**
     * @var boolean $droitCotisations
     */
    private $droitCotisations;

    /**
     * @var \DateTime $createdAt
     */
    private $createdAt;

    /**
     * @var \DateTime $updatedAt
     */
    private $updatedAt;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set asso
     *
     * @param string $asso
     * @return Authkey
     */
    public function setAsso($asso)
    {
        $this->asso = $asso;
    
        return $this;
    }

    /**
     * Get asso
     *
     * @return string 
     */
    public function getAsso()
    {
        return $this->asso;
    }

    /**
     * Set details
     *
     * @param string $details
     * @return Authkey
     */
    public function setDetails($details)
    {
        $this->details = $details;
    
        return $this;
    }

    /**
     * Get details
     *
     * @return string 
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Set cle
     *
     * @param string $cle
     * @return Authkey
     */
    public function setCle($cle)
    {
        $this->cle = $cle;
    
        return $this;
    }

    /**
     * Get cle
     *
     * @return string 
     */
    public function getCle()
    {
        return $this->cle;
    }

    /**
     * Set droitEcriture
     *
     * @param boolean $droitEcriture
     * @return Authkey
     */
    public function setDroitEcriture($droitEcriture)
    {
        $this->droitEcriture = $droitEcriture;
    
        return $this;
    }

    /**
     * Get droitEcriture
     *
     * @return boolean 
     */
    public function getDroitEcriture()
    {
        return $this->droitEcriture;
    }

    /**
     * Set droitBadges
     *
     * @param boolean $droitBadges
     * @return Authkey
     */
    public function setDroitBadges($droitBadges)
    {
        $this->droitBadges = $droitBadges;
    
        return $this;
    }

    /**
     * Get droitBadges
     *
     * @return boolean 
     */
    public function getDroitBadges()
    {
        return $this->droitBadges;
    }

    /**
     * Set droitCotisations
     *
     * @param boolean $droitCotisations
     * @return Authkey
     */
    public function setDroitCotisations($droitCotisations)
    {
        $this->droitCotisations = $droitCotisations;
    
        return $this;
    }

    /**
     * Get droitCotisations
     *
     * @return boolean 
     */
    public function getDroitCotisations()
    {
        return $this->droitCotisations;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Authkey
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Authkey
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    /**
     * @var \DateTime $created_at
     */
    private $created_at;

    /**
     * @var \DateTime $updated_at
     */
    private $updated_at;


}