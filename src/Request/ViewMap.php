<?php

namespace OpenTribes\Core\Request;

/**
 * Description of ViewMap
 *
 * @author BlackScorp<witalimik@web.de>
 */
class ViewMap
{

    private $posY;
    private $posX;
    private $username;
    private $viewportWidth;
    private $viewportHeight;

    public function __construct($posY, $posX, $username, $viewportHeight, $viewportWidth)
    {
        $this->posY = $posY;
        $this->posX = $posX;
        $this->username = $username;
        $this->viewportHeight = $viewportHeight;
        $this->viewportWidth = $viewportWidth;
    }

    public function getPosY()
    {
        return $this->posY;
    }

    public function getPosX()
    {
        return $this->posX;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    public function getViewportWidth()
    {
        return $this->viewportWidth;
    }

    public function getViewportHeight()
    {
        return $this->viewportHeight;
    }
}
