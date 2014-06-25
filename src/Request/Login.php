<?php

namespace OpenTribes\Core\Request;

/**
 * Description of Login
 *
 * @author BlackScorp<witalimik@web.de>
 */
class Login
{

    private $username;
    private $password;
    private $datetime;

    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
        $this->datetime = new \DateTime;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getDatetime()
    {
        return $this->datetime;
    }

    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;
    }
}
