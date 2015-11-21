<?php

namespace OpenTribes\Core\Test\Mock\Response;


use OpenTribes\Core\Response\ListCitiesResponse;
use OpenTribes\Core\View\CityListView;

class MockListCitiesResponse implements ListCitiesResponse{
    private $cities = [];

    /**
     * @return array
     */
    public function getCities()
    {
        return $this->cities;
    }

    public function addCity(CityListView $city)
    {
       $this->cities[]=$city;
    }


}