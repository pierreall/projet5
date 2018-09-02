<?php

namespace App\Entity;

class SearchBook
{
    private $ouvrage;

    /**
     * @return mixed
     */
    public function getOuvrage ()
    {
        return array($this->ouvrage);
    }

    /**
     * @param mixed $ouvrage
     */
    public function setOuvrage ($ouvrage): void
    {
        $this->ouvrage = $ouvrage[0];
    }





}