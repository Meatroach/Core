<?php

namespace OpenTribes\Core\Service;
use OpenTribes\Core\Mail;
interface MailSender{
    public function send(Mail $mail);
}
