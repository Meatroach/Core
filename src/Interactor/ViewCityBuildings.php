<?php

namespace OpenTribes\Core\Interactor;

use OpenTribes\Core\Repository\Building as BuildingRepository;
use OpenTribes\Core\Repository\CityBuildings as CityBuildingsRepository;
use OpenTribes\Core\Request\ViewCityBuildings as ViewCityBuildingsRequest;
use OpenTribes\Core\Response\ViewCityBuildings as ViewCityBuildingsResponse;
use OpenTribes\Core\View\CityBuilding as CityBuildingView;

/**
 * Description of ViewBuildings
 *
 * @author BlackScorp<witalimik@web.de>
 */
class ViewCityBuildings
{

    private $cityBuildingsRepository;
    private $buildingRepository;

    public function __construct(CityBuildingsRepository $cityRepository, BuildingRepository $buildingRepository)
    {
        $this->cityBuildingsRepository = $cityRepository;
        $this->buildingRepository = $buildingRepository;
    }

    public function process(ViewCityBuildingsRequest $request, ViewCityBuildingsResponse $response)
    {
        $city = $this->cityBuildingsRepository->findByLocation($request->getPosY(), $request->getPosX());
        if (!$city) {
            return false;
        }
        if (!$city->hasBuildings()) {
            $this->createBuildings($city);
        }

        foreach ($city->getBuildings() as $building) {
            $response->buildings[] = new CityBuildingView($building);
        }
        return false;
    }

    /**
     * @param \OpenTribes\Core\Entity\City $city
     */
    private function createBuildings($city)
    {
        $buildings = $this->buildingRepository->findAll();
        foreach ($buildings as $building) {
            $city->addBuilding($building);
        }
    }

}
