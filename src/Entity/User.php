<?php

namespace OpenTribes\Core\Entity;

/**
 * User Entity
 *
 * @author BlackScorp<witalimik@web.de>
 */
class User
{

    /**
     * @var integer
     */
    private $userId;

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
    private $registrationDate;

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
     * @param integer $userId
     * @param string $username
     * @param string $password
     * @param string $email
     */
    public function __construct($userId, $username, $password, $email)
    {
        $this->userId = (int)$userId;
        $this->username = $username;
        $this->password = $password;
        $this->email    = $email;
    }

    /**
     * @return string|null
     */
    public function getActivationCode()
    {
        return $this->activationCode;
    }

    /**
     * @param string|null $activationCode
     */
    public function setActivationCode($activationCode)
    {
        $this->activationCode = $activationCode;
    }

    /**
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    public function getRegistrationDate()
    {
        return $this->registrationDate;
    }

    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    public function getLastAction()
    {
        return $this->lastAction;
    }

    public function setRegistrationDate(\DateTime $registrationDate)
    {
        $this->registrationDate = $registrationDate;
    }

    public function setLastAction(\DateTime $lastAction)
    {
        $this->lastAction = $lastAction;
    }

    public function setLastLogin(\DateTime $lastLogin)
    {
        $this->lastLogin = $lastLogin;
    }

}
