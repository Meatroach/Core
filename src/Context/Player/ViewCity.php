<?php

namespace OpenTribes\Core\Context\Player;

use OpenTribes\Core\Repository\Building as BuildingRepository;
use OpenTribes\Core\Repository\CityBuildings as CityBuildingsRepository;
use OpenTribes\Core\Request\ViewCity as ViewCityRequest;
use OpenTribes\Core\Response\ViewCity as ViewCityResponse;

/**
 * Description of ViewBuildings
 *
 * @author BlackScorp<witalimik@web.de>
 */
class ViewCity {

    private $cityBuildingsRepository;
    private $buildingRepository;
    private $response;
    public function __construct(CityBuildingsRepository $cityRepository, BuildingRepository $buildingRepository) {
        $this->cityBuildingsRepository = $cityRepository;
        $this->buildingRepository      = $buildingRepository;
    }

    public function process(ViewCityRequest $request, ViewCityResponse $response) {
        $city = $this->cityBuildingsRepository->findByLocation($request->getY(), $request->getX());
        $this->response = $response;
        if (!$city) {
            return false;
        }
        
        $isCustomCity = $city->getOwner()->getUsername() === $request->getUsername();
        if ($isCustomCity) {
            $this->viewBuildings($y, $x);
        }else{
            $this->viewInformations($y, $x);
        }
        $response->isCustomCity = $isCustomCity;
     
        return true;
    }

    private function viewBuildings($y, $x) {
        
    }

    private function viewInformations($y, $x) {
        
    }

}
