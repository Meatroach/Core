<?php

namespace OpenTribes\Core\Test\Mock\Request;


use OpenTribes\Core\Request\ListDirectionsRequest;

class MockListDirectionsRequest implements ListDirectionsRequest{
    private $direction = '';

    /**
     * @param string $direction
     */
    public function setDirection($direction)
    {
        $this->direction = $direction;
    }



    /**
     * @return string
     */
    public function getDirection()
    {
        return $this->direction;
    }

}