<?php

namespace OpenTribes\Core\Domain\Request;

/**
 * Description of ActivateUser
 *
 * @author BlackScorp<witalimik@web.de>
 */
class ActivateUser {
    private $username;
    private $activationCode;
    function __construct($username, $activationCode) {
        $this->username       = $username;
        $this->activationCode = $activationCode;
    }
    public function getUsername() {
        return $this->username;
    }

    public function getActivationCode() {
        return $this->activationCode;
    }

}
