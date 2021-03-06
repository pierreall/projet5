<?php
// src/Entity/User.php
namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Table(name="app_users")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields="email", message="Email déjà utilisé")
 * @UniqueEntity(fields="username", message="Nom d'utilisateur déjà utilisé")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Ouvrage", mappedBy="user")
     */
    private $ouvrages;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     * @Assert\NotBlank(message = "ce champ ne peut être vide")
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank(message = "Ce champ ne peut être vide")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=254, unique=true)
     * @Assert\NotBlank(message = "ce champ ne peut être vide")
     * @Assert\Email(message = "email invalide")
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



    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="nameUser", orphanRemoval=true)
     */
    private $comments;


    public function __construct()
    {
        $this->isActive = true;
        $this->ouvrages = new ArrayCollection();
        $this->comments = new ArrayCollection();
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


    /**
     * @return mixed
     */
    public function getOuvrages ()
    {
        return $this->ouvrages;
    }

    /**
     * @param mixed $ouvrages
     */
    public function setOuvrages ($ouvrages): void
    {
        $this->ouvrages = $ouvrages;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }



//    public function addComment(Comment $comment): self
//    {
//        if (!$this->comments->contains($comment)) {
//            $this->comments[] = $comment;
//            $comment->setNameUser($this);
//        }
//
//        return $this;
//    }
//
//    public function removeComment(Comment $comment): self
//    {
//        if ($this->comments->contains($comment)) {
//            $this->comments->removeElement($comment);
//            // set the owning side to null (unless already changed)
//            if ($comment->getNameUser() === $this) {
//                $comment->setNameUser(null);
//            }
//        }
//
//        return $this;
//    }





}
