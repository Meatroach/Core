<?php

namespace OpenTribes\Core\Context\Player;

use OpenTribes\Core\Request\CreateNewCity as CreateNewCityRequest;
use OpenTribes\Core\Response\CreateNewCity as CreateNewCityResponse;
use OpenTribes\Core\Interactor\CreateCity as CreateCityInteractor;
use OpenTribes\Core\Response\CreateCity as CreateCityResponse;
use OpenTribes\Core\Request\CreateCity as CreateCityRequest;
use OpenTribes\Core\Interactor\SelectLocation as SelectLocationInteractor;
use OpenTribes\Core\Response\SelectLocation as SelectLocationResponse;
use OpenTribes\Core\Request\SelectLocation as SelectLocationRequest;
use OpenTribes\Core\Repository\City as CityRepository;
use OpenTribes\Core\Repository\Map as MapRepository;
use OpenTribes\Core\Repository\User as UserRepository;
use OpenTribes\Core\Service\LocationCalculator;

/**
 * Description of CreateNewCity
 *
 * @author BlackScorp<witalimik@web.de>
 */
class CreateNewCity {

    private $cityRepository;
    private $mapRepository;
    private $userRepository;
    private $locationCalculator;

    function __construct(CityRepository $cityRepository, MapRepository $mapRepository, UserRepository $userRepository, LocationCalculator $locationCalculator) {
        $this->cityRepository     = $cityRepository;
        $this->mapRepository      = $mapRepository;
        $this->userRepository     = $userRepository;
        $this->locationCalculator = $locationCalculator;
    }

    public function process(CreateNewCityRequest $request, CreateNewCityResponse $response) {
        $direction                = $request->getDirection();
        $username                 = $request->getUsername();
        $defaultCityName          = $request->getDefaultCityName();
        $selectLocationInteractor = new SelectLocationInteractor($this->locationCalculator);
        $selectLocationRequest    = new SelectLocationRequest($direction);
        $selectLocationResponse   = new SelectLocationResponse();
        $createCityInteractor     = new CreateCityInteractor($this->cityRepository, $this->mapRepository, $this->userRepository);
        $createCityResponse       = new CreateCityResponse();
   
        $seed = time();
        mt_srand(1395705254);
        var_dump($seed);
        do {
            $selectLocationInteractor->process($selectLocationRequest, $selectLocationResponse);
            $createCityRequest = new CreateCityRequest($selectLocationResponse->y, $selectLocationResponse->x, $username, $defaultCityName);
            $cityNotCreated    = !$createCityInteractor->process($createCityRequest, $createCityResponse);
     
        } while ($cityNotCreated);
        $response->city = $createCityResponse->city;
        return true;
    }

}
