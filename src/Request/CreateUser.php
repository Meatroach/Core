<?php

namespace OpenTribes\Core\Domain\Request;

/**
 * Description of CreateUser
 *
 * @author BlackScorp<witalimik@web.de>
 */
class CreateUser {

    private $username;
    private $password;
    private $email;

    function __construct($username, $password, $email) {
        $this->username = $username;
        $this->password = $password;
        $this->email    = $email;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getEmail() {
        return $this->email;
    }

}
