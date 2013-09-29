<?php

namespace OpenTribes\Core\Mock\Service;

use OpenTribes\Core\Service\Mailer as MailerInterface;
use OpenTribes\Core\Mail;
class FileMailer implements MailerInterface{
    public function send(Mail $mail) {
        return true;
    }
}