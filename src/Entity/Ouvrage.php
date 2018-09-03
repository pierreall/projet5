<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="ouvrage")
 * @ORM\Entity(repositoryClass="App\Repository\OuvrageRepository")
 */
class Ouvrage
{
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="ouvrages")
     *
     *
     */
    private $user;
    public function __construct ()
    {
        $this->comments = new ArrayCollection();
//        $this->user = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="ce champ ne peut être vide")
     */
    private $title;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank()
     */
    private $subTitle;


    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message = "ce champ ne peut être vide")
     */
    private $resume;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message = "ce champ ne peut être vide")
     */
    private $author;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $editor;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Isbn(type="null", message="Isbn invalide")
     */
    private $Isbnumber;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\File(maxSize = "1024k", maxSizeMessage="L'image est trop volumineuse (> 1mo)", mimeTypes={"image/jpeg", "image/jpg", "image/png"},  mimeTypesMessage  = "Type de fichier invalide, sont acceptés les images jpeg, jpg et png")
     */
    private $picture;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateReservation;



    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $dewey;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="nameOuvrage", orphanRemoval=true)
     */
    private $comments;


    /**
     * @ORM\Column(type="string")
     */
    private $status;


    /**
     * @return mixed
     */
    public function getTitle ()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getDewey ()
    {
        return array($this->dewey);
    }

    /**
     * @param mixed $dewey
     */
    public function setDewey ($dewey): void
    {
        $this->dewey = $dewey[0];
    }

    /**
     * @param mixed $title
     */
    public function setTitle ($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getSubTitle ()
    {
        return $this->subTitle;
    }

    /**
     * @param mixed $subTitle
     */
    public function setSubTitle ($subTitle): void
    {
        $this->subTitle = $subTitle;
    }


    /**
     * @return mixed
     */
    public function getResume ()
    {
        return $this->resume;
    }

    /**
     * @param mixed $resume
     */
    public function setResume ($resume): void
    {
        $this->resume = $resume;
    }

    /**
     * @return mixed
     */
    public function getAuthor ()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor ($author): void
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getEditor ()
    {
        return $this->editor;
    }

    /**
     * @param mixed $editor
     */
    public function setEditor ($editor): void
    {
        $this->editor = $editor;
    }

    /**
     * @return mixed
     */
    public function getIsbnumber ()
    {
        return $this->Isbnumber;
    }

    /**
     * @param mixed $Isbnumber
     */
    public function setIsbnumber ($Isbnumber): void
    {
        $this->Isbnumber = $Isbnumber;
    }




    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPicture ()
    {
        return $this->picture;
    }

    /**
     * @param mixed $picture
     */
    public function setPicture ($picture): void
    {
        $this->picture = $picture;
    }

    /**
     * @return mixed
     */
    public function getUser ()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser ($user): void
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getDateReservation ()
    {
        return $this->dateReservation;
    }

    /**
     * @param mixed $dateReservation
     */
    public function setDateReservation ($dateReservation): void
    {
        $this->dateReservation = $dateReservation;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    /**
     * @return mixed
     */
    public function getStatus ()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus ($status): void
    {
        $this->status = $status;
    }



//    public function addComment(Comment $comment): self
//    {
//        if (!$this->comments->contains($comment)) {
//            $this->comments[] = $comment;
//            $comment->setNameOuvrage($this);
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
//            if ($comment->getNameOuvrage() === $this) {
//                $comment->setNameOuvrage(null);
//            }
//        }
//
//        return $this;
//    }



}
