<?php

namespace OpenTribes\Core\Request;

/**
 * Description of ActivateUser
 *
 * @author BlackScorp<witalimik@web.de>
 */
class ActivateUser {
    private $username;
    private $activationCode;
    
    public function __construct($username, $activationCode) {
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
