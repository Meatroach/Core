<?php

namespace OpenTribes\Core\Request;

/**
 * Description of ViewCityy
 *
 * @author BlackScorp<witalimik@web.de>
 */
class ViewCityBuildings
{

    private $posY;
    private $posX;

    /**
     * @param integer $posY
     * @param integer $posX
     */
    public function __construct($posY, $posX)
    {

        $this->posY = $posY;
        $this->posX = $posX;
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
