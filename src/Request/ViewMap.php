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
    private $width;
    private $height;

    public function __construct($y, $x, $username, $height, $width) {
        $this->y        = $y;
        $this->x        = $x;
        $this->username = $username;
        $this->height   = $height;
        $this->width    = $width;
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

    public function getWidth() {
        return $this->width;
    }

    public function getHeight() {
        return $this->height;
    }

}
