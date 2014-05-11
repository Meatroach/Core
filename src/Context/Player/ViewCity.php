<?php

namespace OpenTribes\Core\Context\Player;

use OpenTribes\Core\Repository\Building as BuildingRepository;
use OpenTribes\Core\Repository\CityBuildings as CityBuildingsRepository;
use OpenTribes\Core\Request\ViewCity as ViewCityRequest;
use OpenTribes\Core\Response\ViewCity as ViewCityResponse;
use OpenTribes\Core\Interactor\ViewCityBuildings as ViewCityBuildingsInteractor;
use OpenTribes\Core\Request\ViewCityBuildings as ViewCityBuildingsRequest;
use OpenTribes\Core\Response\ViewCityBuildings as ViewCityBuildingsReponse;

/**
 * Description of ViewBuildings
 *
 * @author BlackScorp<witalimik@web.de>
 */
class ViewCity {

    private $cityBuildingsRepository;
    private $buildingRepository;

    /**
     * @var ViewCityResponse
     */
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
        $x            = $request->getX();
        $y            = $request->getY();
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
        $request    = new ViewCityBuildingsRequest($y, $x);
        $response   = new ViewCityBuildingsReponse;
        $interactor       = new ViewCityBuildingsInteractor($this->cityBuildingsRepository, $this->buildingRepository);
        $response->failed = $interactor->process($request, $response);
        $this->response->buildings = $response->buildings;
    }

    private function viewInformations($y, $x) {
        return array($y,$x);
    }

}
