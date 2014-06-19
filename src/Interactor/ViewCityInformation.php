<?php


namespace OpenTribes\Core\Interactor;

use OpenTribes\Core\Repository\City as CityRepository;
use OpenTribes\Core\Request\ViewCityInformation as ViewCityInformationRequest;
use OpenTribes\Core\Response\ViewCityInformation as ViewCityInformationResponse;
use OpenTribes\Core\View\City as CityView;

class ViewCityInformation
{
    /**
     * @var CityRepository
     */
    private $cityRepository;

    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    public function process(ViewCityInformationRequest $request, ViewCityInformationResponse $response)
    {
        $city = $this->cityRepository->findByLocation($request->getPosY(), $request->getPosX());
        if (!$city) {
            return false;
        }
        $response->city = new CityView($city);
        return true;
    }
} 