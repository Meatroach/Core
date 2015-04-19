<?php

namespace OpenTribes\Core\Silex\Response;


use OpenTribes\Core\Response\ListDirectionsResponse;
use OpenTribes\Core\View\DirectionView;

class CityResponse extends SymfonyBaseResponse implements ListDirectionsResponse{
    public $directions = [];
    public function addDirection(DirectionView $direction)
    {
       $this->directions[]=$direction;
    }

}