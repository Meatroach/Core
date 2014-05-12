<?php

namespace OpenTribes\Core\Entity;

/**
 * User Entity
 *
 * @author BlackScorp<witalimik@web.de>
 */
class User {

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $activationCode;
    
    /**
     * @var \DateTime
     */
    private $registered;
    
    /**
     * @var \DateTime
     */
    private $lastAction;
    
    /**
     * @var \DateTime
     */
    private $lastLogin;

    /**
     *
     * @param integer $id
     * @param string $username
     * @param string $password
     * @param string $email
     * @param \DateTime $registered
     * @param \DateTime $lastAction
     * @param \DateTime $lastLogin
     */
    public function __construct($id, $username, $password, $email, \DateTime $registered, \DateTime $lastAction, \DateTime $lastLogin) {
        $this->id         = (int) $id;
        $this->username   = $username;
        $this->password   = $password;
        $this->email      = $email;
        $this->registered = $registered;
        $this->lastAction = $lastAction;
        $this->lastLogin  = $lastLogin;
    }

    /**
     * @return string|null
     */
    public function getActivationCode() {
        return $this->activationCode;
    }

    /**
     * @param string|null $activationCode
     */
    public function setActivationCode($activationCode) {
        $this->activationCode = $activationCode;
    }

    /**
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }
    
    public function getRegistrationDate() {
        return $this->registered;
    }
    
    public function getLastLogin() {
        return $this->lastLogin;
    }
    
    public function getLastAction() {
        return $this->getLastAction;
    }

}
