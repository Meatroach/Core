<?php

namespace OpenTribes\Core\Silex\Request;


use OpenTribes\Core\Request\ListDirectionsRequest;
use Symfony\Component\HttpFoundation\Request;

class CityRequest implements ListDirectionsRequest {
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getDirection()
    {
       return $this->request->get('direction');
    }

}