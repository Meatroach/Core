<?php

namespace OpenTribes\Core\Request;

/**
 * Description of ViewCityy
 *
 * @author BlackScorp<witalimik@web.de>
 */
class ViewCity {

    private $username;
    private $y;
    private $x;

    public function __construct($username, $y, $x) {
        $this->username = $username;
        $this->y        = $y;
        $this->x        = $x;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getY() {
        return $this->y;
    }

    public function getX() {
        return $this->x;
    }

}
