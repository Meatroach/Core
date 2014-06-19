<?php

namespace OpenTribes\Core\Request;

/**
 * Description of CreateCity
 *
 * @author BlackScorp<witalimik@web.de>
 */
class CreateCity
{

    private $posX;
    private $posY;
    private $username;
    private $defaultCityName;


    /**
     * @param string $defaultCityName
     * @param integer $posY
     * @param integer $posX
     */
    public function __construct($posY, $posX, $username, $defaultCityName)
    {
        $this->posX = $posX;
        $this->posY = $posY;
        $this->username = $username;
        $this->defaultCityName = $defaultCityName;

    }

    public function getDefaultCityName()
    {
        return $this->defaultCityName;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    public function getPosX()
    {
        return $this->posX;
    }

    public function getPosY()
    {
        return $this->posY;
    }


}
