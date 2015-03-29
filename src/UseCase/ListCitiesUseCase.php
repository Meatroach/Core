<?php

namespace OpenTribes\Core\UseCase;


use OpenTribes\Core\Repository\CityRepository;
use OpenTribes\Core\Request\ListCitiesRequest;
use OpenTribes\Core\Response\ListCitiesResponse;
use OpenTribes\Core\View\CityListView;

class ListCitiesUseCase
{
    /**
     * @var CityRepository
     */
    private $userCityRepository;

    public function __construct(CityRepository $userCityRepository)
    {
        $this->userCityRepository = $userCityRepository;
    }

    public function process(ListCitiesRequest $request,ListCitiesResponse $response){
        $cities = $this->userCityRepository->findAllByUsername($request->getUsername());
        if(count($cities) < 1){
            return;
        }
        foreach($cities as $city){
            $cityListView = new CityListView($city);
            $response->addCity($cityListView);
        }
    }
}