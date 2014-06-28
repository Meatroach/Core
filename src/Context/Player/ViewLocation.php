<?php

namespace OpenTribes\Core\Context\Player;

use OpenTribes\Core\Interactor\ViewCityBuildings as ViewCityBuildingsInteractor;
use OpenTribes\Core\Interactor\ViewCityInformation as ViewCityInformationInteractor;
use OpenTribes\Core\Repository\Building as BuildingRepository;
use OpenTribes\Core\Repository\City as CityRepository;
use OpenTribes\Core\Repository\CityBuildings as CityBuildingsRepository;
use OpenTribes\Core\Request\ViewCityBuildings as ViewCityBuildingsRequest;
use OpenTribes\Core\Request\ViewCityInformation as ViewCityInformationRequest;
use OpenTribes\Core\Request\ViewLocation as ViewLocationRequest;
use OpenTribes\Core\Response\ViewCityBuildings as ViewCityBuildingsReponse;
use OpenTribes\Core\Response\ViewCityInformation as ViewCityInformationResponse;
use OpenTribes\Core\Response\ViewLocation as ViewLocationResponse;

/**
 * Description of ViewBuildings
 *
 * @author BlackScorp<witalimik@web.de>
 */
class ViewLocation
{

    private $cityBuildingsRepository;
    private $buildingRepository;
    private $cityRepository;
    /**
     * @var ViewLocationResponse
     */
    private $response;

    public function __construct(
        CityRepository $cityRepository,
        CityBuildingsRepository $cityBuildingsRepository,
        BuildingRepository $buildingRepository
    ) {
        $this->cityBuildingsRepository = $cityBuildingsRepository;
        $this->cityRepository = $cityRepository;
        $this->buildingRepository = $buildingRepository;
    }

    public function process(ViewLocationRequest $request, ViewLocationResponse $response)
    {
        $city = $this->cityBuildingsRepository->findByLocation($request->getPosY(), $request->getPosX());
        $this->response = $response;
        if (!$city) {
            return false;
        }
        $posX = $request->getPosX();
        $posY = $request->getPosY();
        $isCustomCity = $city->getOwner()->getUsername() === $request->getUsername();
        if ($isCustomCity) {
            $this->viewBuildings($posY, $posX);
        } else {
            $this->viewInformations($posY, $posX);
        }
        $response->isCustomCity = $isCustomCity;

        return true;
    }

    /**
     * @param integer $posY
     * @param integer $posX
     */
    private function viewBuildings($posY, $posX)
    {
        $request = new ViewCityBuildingsRequest($posY, $posX);
        $response = new ViewCityBuildingsReponse;
        $interactor = new ViewCityBuildingsInteractor(
            $this->cityBuildingsRepository,
            $this->buildingRepository
        );
        $response->failed = $interactor->process($request, $response);
        $this->response->buildings = $response->buildings;
    }

    /**
     * @param integer $posY
     * @param integer $posX
     */
    private function viewInformations($posY, $posX)
    {
        $request = new ViewCityInformationRequest($posY, $posX);
        $response = new ViewCityInformationResponse();
        $interactor = new ViewCityInformationInteractor($this->cityRepository);
        $response->failed = $interactor->process($request, $response);
        $this->response->city = $response->city;

    }
}
