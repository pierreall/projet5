<?php

namespace App\Entity;

class Contact
{
    private $mailSubject;


    private $mailFrom;


    private $mailBody;

    /**
     * @return mixed
     */
    public function getMailSubject ()
    {
        return $this->mailSubject;
    }

    /**
     * @param mixed $mailSubject
     */
    public function setMailSubject ($mailSubject): void
    {
        $this->mailSubject = $mailSubject;
    }

    /**
     * @return mixed
     */
    public function getMailFrom ()
    {
        return $this->mailFrom;
    }

    /**
     * @param mixed $mailFrom
     */
    public function setMailFrom ($mailFrom): void
    {
        $this->mailFrom = $mailFrom;
    }

    /**
     * @return mixed
     */
    public function getMailBody ()
    {
        return $this->mailBody;
    }

    /**
     * @param mixed $mailBody
     */
    public function setMailBody ($mailBody): void
    {
        $this->mailBody = $mailBody;
    }





}