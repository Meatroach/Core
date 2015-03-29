<?php

namespace OpenTribes\Core\UseCase;


use OpenTribes\Core\Repository\UserCityRepository;
use OpenTribes\Core\Request\ListCitiesRequest;
use OpenTribes\Core\Response\ListCitiesResponse;
use OpenTribes\Core\View\CityListView;

class ListCitiesUseCase
{
    /**
     * @var UserCityRepository
     */
    private $userCityRepository;

    public function __construct(UserCityRepository $userCityRepository)
    {
        $this->userCityRepository = $userCityRepository;
    }

    public function process(ListCitiesRequest $request,ListCitiesResponse $response){
        $cities = $this->userCityRepository->findAllByUsername($request->getUsername());
        if(!$cities){
            return;
        }
        foreach($cities as $city){
            $cityListView = new CityListView($city);
            $response->addCity($cityListView);
        }
    }
}