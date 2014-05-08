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
    private $viewportWidth;
    private $viewportHeight;

    public function __construct($y, $x, $username, $viewportHeight, $viewportWidth) {
        $this->y        = $y;
        $this->x        = $x;
        $this->username = $username;
        $this->viewportHeight = $viewportHeight;
        $this->viewportWidth  = $viewportWidth;
    }

    public function getY() {
        return $this->y;
    }

    public function getX() {
        return $this->x;
    }

    /**
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    public function getViewportWidth() {
        return $this->viewportWidth;
    }

    public function getViewportHeight() {
        return $this->viewportHeight;
    }

}
