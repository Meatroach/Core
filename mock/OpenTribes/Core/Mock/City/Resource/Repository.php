<?php

namespace OpenTribes\Core\Mock\City\Resource;
use OpenTribes\Core\City\Resource\Repository as CityResourceRepositoryInterface;
use OpenTribes\Core\City\Resource;
use OpenTribes\Core\City;
class Repository implements CityResourceRepositoryInterface{
    private $cityResources = array();
    public function add(Resource $resource) {
        $this->cityResources[]=$resource;
    }
    public function findByCity(City $city) {
        ;
    }
}