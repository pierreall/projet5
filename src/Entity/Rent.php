<?php

namespace App\Entity;

class Rent
{
    private $user;

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



}