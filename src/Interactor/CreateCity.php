<?php

namespace OpenTribes\Core\Interactor;

use OpenTribes\Core\Repository\City as CityRepository;
use OpenTribes\Core\Repository\MapTiles as MapTilesRepository;
use OpenTribes\Core\Repository\User as UserRepository;
use OpenTribes\Core\Request\CreateCity as CreateCityRequest;
use OpenTribes\Core\Response\CreateCity as CreateCityResponse;
use OpenTribes\Core\View\City as CityView;

/**
 * Interactor to create a city, if given location is valid
 *
 * @author BlackScorp<witalimik@web.de>
 */
class CreateCity
{

    /**
     * @var CityRepository
     */
    private $cityRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var MapTilesRepository
     */
    private $mapTilesRepository;

    /**
     * @param CityRepository $cityRepository
     * @param MapTilesRepository $mapTilesRepository
     * @param UserRepository $userRepository
     */
    public function __construct(
        CityRepository $cityRepository,
        MapTilesRepository $mapTilesRepository,
        UserRepository $userRepository
    ) {
        $this->cityRepository = $cityRepository;
        $this->userRepository = $userRepository;
        $this->mapTilesRepository = $mapTilesRepository;
    }

    /**
     * @param CreateCityRequest $request
     * @param CreateCityResponse $response
     * @return boolean
     */
    public function process(CreateCityRequest $request, CreateCityResponse $response)
    {
        $owner = $this->userRepository->findOneByUsername($request->getUsername());
        $positionX = $request->getPosX();
        $positionY = $request->getPosY();
        $name = $request->getDefaultCityName();
        $map = $this->mapTilesRepository->getMap();
        $response->failed = true;
        $response->proceed = true;
        if (!$owner || !$map) {
            return false;
        }
        if (!$map->isValidLocation($positionY, $positionX)) {
            return false;
        }

        if (!$map->isAccessible($positionY, $positionX)) {
            return false;
        }

        if ($this->cityRepository->cityExistsAt($positionY, $positionX)) {
            return false;
        }

        $response->failed = false;
        $cityId = $this->cityRepository->getUniqueId();

        $city = $this->cityRepository->create($cityId, $name, $positionY, $positionX);
        $city->setOwner($owner);
        $city->setSelected(true);
        $this->cityRepository->add($city);
        $response->city = new CityView($city);
        return true;
    }
}
