<?php

namespace OpenTribes\Core\Mock\User\ActivationMail;

use OpenTribes\Core\User\ActivationMail;
use OpenTribes\Core\User\ActivationMail\Repository as ActivationMailRepositoryInterface;

class Repository implements ActivationMailRepositoryInterface{
    public function create() {
        return new ActivationMail();
    }
}
