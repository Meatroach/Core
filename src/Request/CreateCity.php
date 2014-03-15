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

    function __construct($y, $x, $username) {
        $this->x        = $x;
        $this->y        = $y;
        $this->username = $username;
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
