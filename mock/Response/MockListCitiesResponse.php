<?php

namespace OpenTribes\Core\Mock\Response;


use OpenTribes\Core\Response\ListCitiesResponse;

class MockListCitiesResponse implements ListCitiesResponse{
    private $cities = [];

    /**
     * @return array
     */
    public function getCities()
    {
        return $this->cities;
    }


}