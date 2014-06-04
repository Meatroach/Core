<?php

namespace OpenTribes\Core\Request;

/**
 * Description of CreateCity
 *
 * @author BlackScorp<witalimik@web.de>
 */
class CreateCity {

    private $x;
    private $y;
    private $username;
    private $defaultCityName;


    /**
     * @param string $defaultCityName
     */
    public function __construct($y, $x, $defaultCityName) {
        $this->x               = $x;
        $this->y               = $y;
        $this->defaultCityName = $defaultCityName;

    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getDefaultCityName() {
        return $this->defaultCityName;
    }

    /**
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    public function getX() {
        return $this->x;
    }

    public function getY() {
        return $this->y;
    }


}
