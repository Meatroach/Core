<?php

namespace OpenTribes\Core\Request;


class ViewCityInformation
{
    /**
     * @var integer
     */
    private $y;
    /**
     * @var integer
     */
    private $x;

    /**
     * @param integer $x integer
     * @param integer $y interger
     */
    public function __construct($y, $x)
    {
        $this->x = (int)$x;
        $this->y = (int)$y;
    }

    /**
     * @return int
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @return integer
     */
    public function getY()
    {
        return $this->y;
    }

} 