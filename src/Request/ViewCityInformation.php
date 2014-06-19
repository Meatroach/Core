<?php

namespace OpenTribes\Core\Request;


class ViewCityInformation
{
    /**
     * @var integer
     */
    private $posY;
    /**
     * @var integer
     */
    private $posX;

    /**
     * @param integer $posX integer
     * @param integer $posY interger
     */
    public function __construct($posY, $posX)
    {
        $this->posX = (int)$posX;
        $this->posY = (int)$posY;
    }

    /**
     * @return int
     */
    public function getPosX()
    {
        return $this->posX;
    }

    /**
     * @return integer
     */
    public function getPosY()
    {
        return $this->posY;
    }
}
