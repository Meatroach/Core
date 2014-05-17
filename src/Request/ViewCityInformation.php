<?php

namespace OpenTribes\Core\Request;


class ViewCityInformation {
    /**
     * @var integer
     */
    private $y;
    /**
     * @var integer
     */
    private $x;

    /**
     * @param $x integer
     * @param $y interger
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
     * @return mixed
     */
    public function getY()
    {
        return $this->y;
    }

} 