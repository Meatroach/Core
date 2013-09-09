<?php

namespace OpenTribes\Core;

use OpenTribes\Core\Player\Roles;
use OpenTribes\Core\Player\Exception\Username\Short as UserNameTooShortException;
use OpenTribes\Core\Player\Exception\Username\Long as UserNameTooLongException;
use OpenTribes\Core\Player\Exception\Username\Invalid as UserNameInvalidException;
use OpenTribes\Core\Player\Exception\Username\EmptyException as UserNameEmptyException;
use OpenTribes\Core\Player\Exception\Password\EmptyException as PasswordEmptyException;
use OpenTribes\Core\Player\Exception\Password\Short as PasswordTooShortException;
use OpenTribes\Core\Player\Exception\Email\EmptyException as EmailEmptyException;
use OpenTribes\Core\Player\Exception\Email\Invalid as EmailInvalidException;

class Player extends Entity {

    protected $roles;
    protected $username;
    protected $password;
    protected $email;
    protected $lastAction;
    protected $activationCode;

    public function setActivationCode($code) {
        $this->activationCode = $code;
        return $this;
    }

    public function setLastAction(\DateTime $lastAction = null) {
        $this->lastAction = $lastAction? : new \DateTime();
        return $this;
    }

    public function setPassword($password) {
        if (in_array($password, array(null, false, '', array()), true))
            throw new PasswordEmptyException;
        if (strlen($password) < 6)
            throw new PasswordTooShortException;

        $this->password = $password;
        return $this;
    }

    public function setUsername($username) {
        if (in_array($username, array(null, false, '', array()), true))
            throw new UserNameEmptyException;
        if ((bool) preg_match('/^[-a-z0-9_]++$/iD', $username) === false)
            throw new UserNameInvalidException;
        if (strlen($username) < 4)
            throw new UserNameTooShortException;
        if (strlen($username) > 32)
            throw new UserNameTooLongException;

        $this->username = $username;
        return $this;
    }

    public function setEmail($email) {
        if (in_array($email, array(null, false, '', array()), true))
            throw new EmailEmptyException;
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            throw new EmailInvalidException;
        $this->email = $email;
        return $this;
    }

    public function setRoles(Roles $roles) {
        $roles->setPlayer($this);

        $this->roles = $roles;
        return $this;
    }

    public function getRoles() {
        return $this->roles;
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

    public function getActivationCode() {
        return $this->activationCode;
    }

}

