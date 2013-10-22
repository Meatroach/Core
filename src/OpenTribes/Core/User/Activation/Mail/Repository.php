<?php

namespace OpenTribes\Core\User\Activation\Mail;

use OpenTribes\Core\User\Activation\Mail as ActivationMail;
interface Repository{
public function add(ActivationMail $activationMail);
}
