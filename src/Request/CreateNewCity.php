<?php

namespace OpenTribes\Core\Request;

/**
 * Description of CreateNewCity
 *
 * @author BlackScorp<witalimik@web.de>
 */
class CreateNewCity {
    private $username;
    private $direction;
    private $defaultCityName;


    /**
     * @param string $defaultCityName
     */
    function __construct($username, $direction, $defaultCityName) {
        $this->username        = $username;
        $this->direction       = $direction;
        $this->defaultCityName = $defaultCityName;

    }
    public function getUsername() {
        return $this->username;
    }

    public function getDirection() {
        return $this->direction;
    }

    public function getDefaultCityName() {
        return $this->defaultCityName;
    }
 

}
