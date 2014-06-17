<?php

namespace OpenTribes\Core\Context\Player;

use OpenTribes\Core\Interactor\CreateCity as CreateCityInteractor;
use OpenTribes\Core\Interactor\SelectLocation as SelectLocationInteractor;
use OpenTribes\Core\Repository\City as CityRepository;
use OpenTribes\Core\Repository\MapTiles as MapTilesRepository;
use OpenTribes\Core\Repository\User as UserRepository;
use OpenTribes\Core\Request\CreateCity as CreateCityRequest;
use OpenTribes\Core\Request\CreateNewCity as CreateNewCityRequest;
use OpenTribes\Core\Request\SelectLocation as SelectLocationRequest;
use OpenTribes\Core\Response\CreateCity as CreateCityResponse;
use OpenTribes\Core\Response\CreateNewCity as CreateNewCityResponse;
use OpenTribes\Core\Response\SelectLocation as SelectLocationResponse;
use OpenTribes\Core\Service\LocationCalculator;

/**
 * Description of CreateNewCity
 *
 * @author BlackScorp<witalimik@web.de>
 */
class CreateNewCity
{

    private $cityRepository;
    private $mapTilesRepository;
    private $userRepository;
    private $locationCalculator;

    public function __construct(
    CityRepository $cityRepository, MapTilesRepository $mapTilesRepository, UserRepository $userRepository, LocationCalculator $locationCalculator
    )
    {
        $this->cityRepository     = $cityRepository;
        $this->mapTilesRepository = $mapTilesRepository;
        $this->userRepository     = $userRepository;
        $this->locationCalculator = $locationCalculator;
    }

    public function process(CreateNewCityRequest $request, CreateNewCityResponse $response)
    {
        $direction         = $request->getDirection();
        $username          = $request->getUsername();
        $defaultCityName   = $request->getDefaultCityName();
        $response->proceed = true;
        $map               = $this->mapTilesRepository->getMap();

        if (!$map) {
            throw new \Exception("Please create a map");
        }


        $this->locationCalculator->setCenterPosition($map->getCenterY(), $map->getCenterX());
        $this->locationCalculator->setCountCities($this->cityRepository->countAll());
        $selectLocationInteractor = new SelectLocationInteractor($this->locationCalculator);
        $selectLocationRequest    = new SelectLocationRequest($direction);
        $selectLocationResponse   = new SelectLocationResponse();

        $createCityInteractor = new CreateCityInteractor($this->cityRepository, $this->mapTilesRepository, $this->userRepository);
        $createCityResponse   = new CreateCityResponse();
        $i                    = 0;
        do {
            $selectLocationInteractor->process($selectLocationRequest, $selectLocationResponse);
            $x = $selectLocationResponse->x;
            $y = $selectLocationResponse->y;

            $createCityRequest = new CreateCityRequest($y, $x, $username, $defaultCityName);
            $cityIsCreated     = $createCityInteractor->process($createCityRequest, $createCityResponse);

            $i++;
            if ($i > 10) {
                $this->locationCalculator->increaseRadius();
            }
            if ($i > 100) {
                return false;
            }
        } while (!$cityIsCreated);

        $response->failed = $createCityResponse->failed;
        $response->city   = $createCityResponse->city;
    }
}
