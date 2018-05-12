<?php
// src/Entity/User.php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="app_users")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields="email", message="Email déjà utilisé")
 * @UniqueEntity(fields="username", message="Nom d'utilisateur déjà utilisé")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank()
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=254, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(name="roles", type="string")
     * @Assert\NotBlank()
     */
    private $roles;



    public function __construct()
    {
        $this->isActive = true;
// may not be needed, see section on salt below
// $this->salt = md5(uniqid('', true));
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getSalt()
    {
// you *may* need a real salt depending on your encoder
// see section on salt below
        return null;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRoles()
    {
//return array('ROLE_USER');
        return array($this->roles);
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
// see section on salt below
// $this->salt,
        ));
    }

    /**
     * @param mixed $username
     */
    public function setUsername ($username): void
    {
        $this->username = $username;
    }

    /**
     * @param mixed $password
     */
    public function setPassword ($password): void
    {
        $this->password = $password;
    }

    /**
     * @param mixed $email
     */
    public function setEmail ($email): void
    {
        $this->email = $email;
    }

    /**
     * @param mixed $isActive
     */
    public function setIsActive ($isActive): void
    {
        $this->isActive = $isActive;
    }

    /**
     * @param mixed $roles
     */
    public function setRoles ($roles): void
    {
        $this->roles = $roles[0];
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
// see section on salt below
// $this->salt
            ) = unserialize($serialized, ['allowed_classes' => false]);
    }

    /**
     * @return mixed
     */
    public function getEmail ()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getisActive ()
    {
        return $this->isActive;
    }

    /**
     * @return mixed
     */
    public function getId ()
    {
        return $this->id;
    }



}
