<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entities\Cotisation
 */
class Cotisation
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var \DateTime $debut
     */
    private $debut;

    /**
     * @var \DateTime $fin
     */
    private $fin;

    /**
     * @var float $montant
     */
    private $montant;

    /**
     * @var \DateTime $createdAt
     */
    private $createdAt;

    /**
     * @var \DateTime $updatedAt
     */
    private $updatedAt;

    /**
     * @var Entities\Personne
     */
    private $personne;


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
     * Set debut
     *
     * @param \DateTime $debut
     * @return Cotisation
     */
    public function setDebut($debut)
    {
        $this->debut = $debut;
    
        return $this;
    }

    /**
     * Get debut
     *
     * @return \DateTime 
     */
    public function getDebut()
    {
        return $this->debut;
    }

    /**
     * Set fin
     *
     * @param \DateTime $fin
     * @return Cotisation
     */
    public function setFin($fin)
    {
        $this->fin = $fin;
    
        return $this;
    }

    /**
     * Get fin
     *
     * @return \DateTime 
     */
    public function getFin()
    {
        return $this->fin;
    }

    /**
     * Set montant
     *
     * @param float $montant
     * @return Cotisation
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;
    
        return $this;
    }

    /**
     * Get montant
     *
     * @return float 
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Cotisation
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
     * @return Cotisation
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
     * Set personne
     *
     * @param Entities\Personne $personne
     * @return Cotisation
     */
    public function setPersonne(\Entities\Personne $personne = null)
    {
        $this->personne = $personne;
    
        return $this;
    }

    /**
     * Get personne
     *
     * @return Entities\Personne 
     */
    public function getPersonne()
    {
        return $this->personne;
    }
}