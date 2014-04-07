<?php

namespace OpenTribes\Core\Request;

/**
 * Description of Login
 *
 * @author BlackScorp<witalimik@web.de>
 */
class Login {

    private $username;
    private $password;

    public function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

}
