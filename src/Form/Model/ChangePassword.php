<?php

// src/Form/Model/ChangePassword.php
namespace App\Form\Model;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;

class ChangePassword
{
    /**
     * @SecurityAssert\UserPassword(
     *     message = "Erreur votre mot de passe actuel ne correspond pas"
     * )
     */
    protected $oldPassword;

    /**
     * @return mixed
     */
    public function getOldPassword ()
    {
        return $this->oldPassword;
    }

    /**
     * @param mixed $oldPassword
     */
    public function setOldPassword ($oldPassword): void
    {
        $this->oldPassword = $oldPassword;
    }



}

