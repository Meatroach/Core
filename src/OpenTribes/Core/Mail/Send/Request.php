<?php

namespace OpenTribes\Core\Mail\Send;

use OpenTribes\Core\Mail;
class Request{
    private $mail;
    public function __construct(Mail $mail) {
        $this->setMail($mail);
        
    }
    public function setMail(Mail $mail){
        $this->mail = $mail;
        return $this;
    }
}
