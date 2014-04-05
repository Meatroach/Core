<?php

namespace OpenTribes\Core\Request;

/**
 * Description of ViewMap
 *
 * @author BlackScorp<witalimik@web.de>
 */
class ViewMap {

    private $y;
    private $x;
    private $username;
    public function __construct($y, $x,$username) {
        $this->y = $y;
        $this->x = $x;
        $this->username = $username;
    }

    public function getY() {
        return $this->y;
    }

    public function getX() {
        return $this->x;
    }
    public function getUsername() {
        return $this->username;
    }


}
