<?php

namespace OpenTribes\Core\Entity;


use DateTime;

class UserEntity
{
    private $userId = 0;
    private $username = '';
    private $passwordHash = '';
    private $email = '';
    private $registrationDate = null;
    public function __construct($userId, $username, $passwordHash, $email)
    {
        $this->userId = $userId;
        $this->username = $username;
        $this->passwordHash = $passwordHash;
        $this->email = $email;
    }


    /**
     * @param DateTime $registrationDate
     */
    public function setRegistrationDate(DateTime $registrationDate)
    {
        $this->registrationDate = $registrationDate;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getPasswordHash()
    {
        return $this->passwordHash;
    }


} 