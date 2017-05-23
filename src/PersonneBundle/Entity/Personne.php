<?php

namespace PersonneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Personne
 *
 * @ORM\Table(name="personne")
 * @ORM\Entity(repositoryClass="PersonneBundle\Repository\PersonneRepository")
 */
class Personne
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
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     * @Assert\Length( min=4)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=255)
     * @Assert\Length( max=1)
     */
    private $sexe;

    /**
     * @var int
     *
     * @ORM\Column(name="numero", type="integer")
     */
    private $numero;

    /**
     * @var string
     *
     * @ORM\Column(name="rue", type="string", length=255)
     */
    private $rue;

    /**
     * @var int
     *
     * @ORM\Column(name="codePostal", type="integer")
     * @Assert\Length( min=5 , max=5)
     */
    private $codePostal;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255)
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=255)
     */
    private $photo;

    /**
     * @ORM\OneToMany(targetEntity="Memo", mappedBy="personne")
     */
    private $memos;

     /**
     * @ORM\ManyToMany(targetEntity="FormationBundle\Entity\Session", mappedBy="sessions")
     */
    private $sessions;

     /**
     *
     * @ORM\ManyToMany(targetEntity="Formateur", inversedBy="personnes")
     */
    private $formateurs;

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
     * @return Personne
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
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Personne
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Personne
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Personne
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     *
     * @return Personne
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set numero
     *
     * @param integer $numero
     *
     * @return Personne
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return int
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set rue
     *
     * @param string $rue
     *
     * @return Personne
     */
    public function setRue($rue)
    {
        $this->rue = $rue;

        return $this;
    }

    /**
     * Get rue
     *
     * @return string
     */
    public function getRue()
    {
        return $this->rue;
    }

    /**
     * Set codePostal
     *
     * @param integer $codePostal
     *
     * @return Personne
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get codePostal
     *
     * @return int
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Personne
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set photo
     *
     * @param string $photo
     *
     * @return Personne
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->memos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add memo
     *
     * @param \PersonneBundle\Entity\Memo $memo
     *
     * @return Personne
     */
    public function addMemo(\PersonneBundle\Entity\Memo $memo)
    {
        $this->memos[] = $memo;

        return $this;
    }

    /**
     * Remove memo
     *
     * @param \PersonneBundle\Entity\Memo $memo
     */
    public function removeMemo(\PersonneBundle\Entity\Memo $memo)
    {
        $this->memos->removeElement($memo);
    }

    /**
     * Get memos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMemos()
    {
        return $this->memos;
    }

    /**
     * Add session
     *
     * @param \FormationBundle\Entity\Session $session
     *
     * @return Personne
     */
    public function addSession(\FormationBundle\Entity\Session $session)
    {
        $this->sessions[] = $session;

        return $this;
    }

    /**
     * Remove session
     *
     * @param \FormationBundle\Entity\Session $session
     */
    public function removeSession(\FormationBundle\Entity\Session $session)
    {
        $this->sessions->removeElement($session);
    }

    /**
     * Get sessions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSessions()
    {
        return $this->sessions;
    }

    /**
     * Add formateur
     *
     * @param \PersonneBundle\Entity\Formateur $formateur
     *
     * @return Personne
     */
    public function addFormateur(\PersonneBundle\Entity\Formateur $formateur)
    {
        $this->formateurs[] = $formateur;

        return $this;
    }

    /**
     * Remove formateur
     *
     * @param \PersonneBundle\Entity\Formateur $formateur
     */
    public function removeFormateur(\PersonneBundle\Entity\Formateur $formateur)
    {
        $this->formateurs->removeElement($formateur);
    }

    /**
     * Get formateurs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFormateurs()
    {
        return $this->formateurs;
    }
}
