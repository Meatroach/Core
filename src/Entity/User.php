<?php

namespace OpenTribes\Core\Domain\Entity;

/**
 * Description of User
 *
 * @author BlackScorp<witalimik@web.de>
 */
class User {

    private $id;
    private $username;
    private $password;
    private $email;
    private $activationCode;
    function __construct($id, $username, $password, $email) {
        $this->id       = $id;
        $this->username = $username;
        $this->password = $password;
        $this->email    = $email;
    }
    public function getActivationCode() {
        return $this->activationCode;
    }

    public function setActivationCode($activationCode) {
        $this->activationCode = $activationCode;
    }

        public function getId() {
        return $this->id;
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
