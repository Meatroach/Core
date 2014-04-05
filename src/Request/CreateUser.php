<?php

namespace OpenTribes\Core\Request;

/**
 * Description of CreateUser
 *
 * @author BlackScorp<witalimik@web.de>
 */
class CreateUser {

    private $username;
    private $password;
    private $email;

    public function __construct($username, $password, $email) {
        $this->username = $username;
        $this->password = $password;
        $this->email    = $email;
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

    /**
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

}
