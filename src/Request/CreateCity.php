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


    function __construct($y, $x, $username, $defaultCityName) {
        $this->x               = $x;
        $this->y               = $y;
        $this->username        = $username;
        $this->defaultCityName = $defaultCityName;

    }

    public function getDefaultCityName() {
        return $this->defaultCityName;
    }

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
