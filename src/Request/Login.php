<?php

namespace OpenTribes\Core\Domain\Request;

/**
 * Description of Login
 *
 * @author BlackScorp<witalimik@web.de>
 */
class Login {

    private $username;
    private $password;

    function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

}
