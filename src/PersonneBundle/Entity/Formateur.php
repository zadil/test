<?php

namespace PersonneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Formateur
 *
 * @ORM\Table(name="formateur")
 * @ORM\Entity(repositoryClass="PersonneBundle\Repository\FormateurRepository")
 */
class Formateur
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;


     /**
     *
     * @ORM\ManyToMany(targetEntity="Personne", mappedBy="formateurs")
     */
    private $personnes;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Formateur
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->personnes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add personne
     *
     * @param \PersonneBundle\Entity\Personne $personne
     *
     * @return Formateur
     */
    public function addPersonne(\PersonneBundle\Entity\Personne $personne)
    {
        $this->personnes[] = $personne;

        return $this;
    }

    /**
     * Remove personne
     *
     * @param \PersonneBundle\Entity\Personne $personne
     */
    public function removePersonne(\PersonneBundle\Entity\Personne $personne)
    {
        $this->personnes->removeElement($personne);
    }

    /**
     * Get personnes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPersonnes()
    {
        return $this->personnes;
    }
}
