<?php

namespace OpenTribes\Core\User\ActivationMail;

use OpenTribes\Core\User\ActivationMail;
interface Repository {
    public function add(ActivationMail $activationMail);
}