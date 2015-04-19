<?php

namespace OpenTribes\Core\Silex\Controller;


use OpenTribes\Core\Repository\CityRepository;
use OpenTribes\Core\Silex\Repository\WritableRepository;
use OpenTribes\Core\Silex\Request\CityRequest;
use OpenTribes\Core\Silex\Response\CityResponse;
use OpenTribes\Core\UseCase\ListDirectionsUseCase;
use Symfony\Component\HttpFoundation\Request;

class CityController extends BaseGameController
{

    private $listDirectionsUseCase;

    public function __construct(
        ListDirectionsUseCase $listDirectionsUseCase,
        WritableRepository $userRepository,
        CityRepository $cityRepository
    ) {
        parent::__construct($userRepository, $cityRepository);
        $this->listDirectionsUseCase = $listDirectionsUseCase;
    }

    public function listAction()
    {

        return '';
    }

    public function createAction(Request $httpRequest)
    {
        $request = new CityRequest($httpRequest);
        $response = new CityResponse();
        $this->listDirectionsUseCase->process($request, $response);


        return $response;
    }
}