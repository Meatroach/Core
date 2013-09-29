<?php

namespace OpenTribes\Core\Service;
use OpenTribes\Core\Mail;
interface Mailer{
    public function send(Mail $mail);
}
