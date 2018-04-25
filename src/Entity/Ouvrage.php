<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OuvrageRepository")
 */
class Ouvrage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $subTitle;

    /**
     * @ORM\Column(type="string")
     */
    private $genre;

    /**
     * @ORM\Column(type="text")
     */
    private $resume;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $author;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $editor;

    /**
     * @ORM\Column(type="bigint", nullable=true)
     */
    private $ISBNumber;

    /**
     * @return mixed
     */
    public function getTitle ()
    {
        return $this->title;
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
    public function getGenre ()
    {
        return $this->genre;
    }

    /**
     * @param mixed $genre
     */
    public function setGenre ($genre): void
    {
        $this->genre = $genre;
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
    public function getISBNumber ()
    {
        return $this->ISBNumber;
    }

    /**
     * @param mixed $ISBNumber
     */
    public function setISBNumber ($ISBNumber): void
    {
        $this->ISBNumber = $ISBNumber;
    }



    public function getId()
    {
        return $this->id;
    }
}
