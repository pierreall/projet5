<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $nameUser;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ouvrage", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $nameOuvrage;


    public function getId()
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getNameUser(): ?User
    {
        return $this->nameUser;
    }

    public function setNameUser(?User $nameUser): self
    {
        $this->nameUser = $nameUser;

        return $this;
    }

    public function getNameOuvrage(): ?Ouvrage
    {
        return $this->nameOuvrage;
    }

    public function setNameOuvrage(?Ouvrage $nameOuvrage): self
    {
        $this->nameOuvrage = $nameOuvrage;

        return $this;
    }


}
