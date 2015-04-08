<?php

namespace OpenTribes\Core\Silex\Controller;


use OpenTribes\Core\Silex\Request\CityRequest;
use OpenTribes\Core\Silex\Response\CityResponse;
use Symfony\Component\HttpFoundation\Request;

class CityController extends AuthenticateController{
    public function listAction(Request $httpRequest){
        $response = new CityResponse();
        $request = new CityRequest();
        return $response;
    }
}