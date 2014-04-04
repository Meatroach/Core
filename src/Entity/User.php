<?php

namespace OpenTribes\Core\Entity;

/**
 * User Entity
 *
 * @author BlackScorp<witalimik@web.de>
 */
class User {

    /**
     * @var \integer
     */
    private $id;

    /**
     * @var \string
     */
    private $username;

    /**
     * @var \string
     */
    private $password;

    /**
     * @var \string
     */
    private $email;

    /**
     * @var \string
     */
    private $activationCode;

    /**
     *
     * @param \integer $id
     * @param \string $username
     * @param \string $password
     * @param \string $email
     */
    public function __construct($id, $username, $password, $email) {
        $this->id       = (int) $id;
        $this->username = $username;
        $this->password = $password;
        $this->email    = $email;
    }

    /**
     * @return \string|null
     */
    public function getActivationCode() {
        return $this->activationCode;
    }

    /**
     * @param \string|null $activationCode
     */
    public function setActivationCode($activationCode) {
        $this->activationCode = $activationCode;
    }

    /**
     * @return \integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return \string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @return \string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @return \string
     */
    public function getEmail() {
        return $this->email;
    }

}
