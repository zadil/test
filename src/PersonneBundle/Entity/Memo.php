<?php

namespace PersonneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Memo
 *
 * @ORM\Table(name="memo")
 * @ORM\Entity(repositoryClass="PersonneBundle\Repository\MemoRepository")
 */
class Memo
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
     * @ORM\Column(name="contenu", type="text")
     */
    private $contenu;

    /**
     * @var boolean
     *
     * @ORM\Column(name="fait", type="boolean")
     */
    private $fait;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="datetime")
     */
    private $dateCreation;

    /**
     * @ORM\ManyToOne(targetEntity="Personne", inversedBy="memos")
     */
    private $personne;



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
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Memo
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Memo
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set personne
     *
     * @param \PersonneBundle\Entity\personne $personne
     *
     * @return Memo
     */
    public function setPersonne(\PersonneBundle\Entity\Personne $personne = null)
    {
        $this->personne = $personne;

        return $this;
    }

    /**
     * Get personne
     *
     * @return \PersonneBundle\Entity\personne
     */
    public function getPersonne()
    {
        return $this->personne;
    }

    /**
     * Set fait
     *
     * @param boolean $fait
     *
     * @return Memo
     */
    public function setFait($fait)
    {
        $this->fait = $fait;

        return $this;
    }

    /**
     * Get fait
     *
     * @return boolean
     */
    public function getFait()
    {
        return $this->fait;
    }
}
