<?php

namespace OpenTribes\Core\Mock\Service;

use OpenTribes\Core\Service\MailSender as MailSenderInterface;
use OpenTribes\Core\Mail;
class DumpMailer implements MailSenderInterface{
    public function send(Mail $mail) {
        return true;
    }
}
