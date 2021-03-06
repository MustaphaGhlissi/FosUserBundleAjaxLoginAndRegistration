<?php

namespace AuthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AuthBundle\Repository\UserRepository")
 * @UniqueEntity(
 *     fields={"username"},
 *     message="Ce nom d'utilisateur est déjà utilisé."
 * )
 * @ORM\Entity(repositoryClass="AuthBundle\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class User extends BaseUser
{
    const ROLE_REDACTOR = 'ROLE_REDACTOR';
    const ROLE_ADMIN    = 'ROLE_ADMIN';
    const ROLE_MEMBER   = 'ROLE_MEMBER';

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(min="3")
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(min="3")
     */
    protected $firstname;

    /**
     * @var FicheClient $ficheClient
     * @Assert\NotBlank()
     * @ORM\OneToOne(targetEntity="AuthBundle\Entity\FicheClient", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    protected $ficheClient;

    public function __construct($client = false)
    {
        parent::__construct();
        if ($client) {
            $this->setFicheClient(new FicheClient());
        }
    }



    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return (string)$this->getFirstname() . ' ' . $this->getName();
    }

    /**
     * @ORM\PrePersist()
     */
    public function setPasswordIfNull()
    {
        if (null === $this->password) {
            $this->setPlainPassword($this->getUsername());
        }
    }

    /*
    public function getRoleTxt()
    {
        $tradRoles = [
            self::ROLE_DEFAULT     => 'Utilisateur',
            self::ROLE_MEMBER      => 'Membre',
            self::ROLE_REDACTOR    => 'Redacteur',
            self::ROLE_ADMIN       => 'Admin',
            self::ROLE_SUPER_ADMIN => 's Admin',
        ];
        $txtRoles  = [];
        foreach ($this->roles as $role) {
            $txtRoles[] = $tradRoles[$role];
        }
        return count($txtRoles) ? $txtRoles : ['Utilisateur'];
    }*/



    /**
     * Set name
     *
     * @param string $name
     *
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }



    /**
     * Set ficheClient
     *
     * @param \AuthBundle\Entity\FicheClient $ficheClient
     *
     * @return User
     */
    public function setFicheClient(\AuthBundle\Entity\FicheClient $ficheClient = null)
    {
        $this->ficheClient = $ficheClient;

        return $this;
    }

    /**
     * Get ficheClient
     *
     * @return \AuthBundle\Entity\FicheClient
     */
    public function getFicheClient()
    {
        return $this->ficheClient;
    }
}
