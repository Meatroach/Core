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
        CityRepository $cityRepository,
        MapTilesRepository $mapTilesRepository,
        UserRepository $userRepository,
        LocationCalculator $locationCalculator
    ) {
        $this->cityRepository     = $cityRepository;
        $this->mapTilesRepository = $mapTilesRepository;
        $this->userRepository     = $userRepository;
        $this->locationCalculator = $locationCalculator;
    }

    public function process(CreateNewCityRequest $request, CreateNewCityResponse $response)
    {
        $direction       = $request->getDirection();
        $username        = $request->getUsername();
        $defaultCityName = $request->getDefaultCityName();

        $map = $this->mapTilesRepository->getMap();

        if (!$map) {
            throw new \Exception("Please create a map");
        }
        $selectLocationInteractor = new SelectLocationInteractor($this->locationCalculator);
        $selectLocationRequest    = new SelectLocationRequest($direction);
        $selectLocationResponse   = new SelectLocationResponse();
        $createCityInteractor     = new CreateCityInteractor($this->cityRepository, $this->mapTilesRepository, $this->userRepository);
        $createCityResponse       = new CreateCityResponse();
        $this->locationCalculator->setOriginPosition($map->getCenterY(), $map->getCenterX());
        $lastCity = $this->cityRepository->getLastCreatedCity();
        if ($lastCity) {
            $this->locationCalculator->setOriginPosition($lastCity->getY(), $lastCity->getX());
        }

        $this->locationCalculator->setCountCities($this->cityRepository->countAll());
        $i = 0;
        do {
            $i++;
            $margin = ~~($i / 5) + 1;
            $this->locationCalculator->setMargin($i);
            $selectLocationInteractor->process($selectLocationRequest, $selectLocationResponse);
            $createCityRequest = new CreateCityRequest($selectLocationResponse->y, $selectLocationResponse->x, $username, $defaultCityName);
            $cityNotCreated    = !$createCityInteractor->process($createCityRequest, $createCityResponse);
            if ($i > 10) {
                return false;
            }
        } while ($cityNotCreated);

        $response->city = $createCityResponse->city;
        return true;
    }

}
