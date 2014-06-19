<?php

namespace OpenTribes\Core\Request;

/**
 * Description of ViewCityy
 *
 * @author BlackScorp<witalimik@web.de>
 */
class ViewLocation
{

    private $username;
    private $posY;
    private $posX;

    public function __construct($username, $posY, $posX)
    {
        $this->username = $username;
        $this->posY = $posY;
        $this->posX = $posX;
    }

    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return integer
     */
    public function getPosY()
    {
        return $this->posY;
    }

    /**
     * @return integer
     */
    public function getPosX()
    {
        return $this->posX;
    }

}
