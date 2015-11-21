<?php

namespace OpenTribes\Core\Test\Mock\Response;


use OpenTribes\Core\Response\ListDirectionsResponse;
use OpenTribes\Core\View\DirectionView;

class MockListDirectionsResponse implements ListDirectionsResponse{
    /**
     * @var DirectionView[]
     */
    public $directions = [];

    public function addDirection(DirectionView $direction)
    {
        $this->directions[]=$direction;
    }

}