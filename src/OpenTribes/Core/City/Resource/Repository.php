<?php
namespace OpenTribes\Core\City\Resource;
use OpenTribes\Core\City\Resource as CityResource;
use OpenTribes\Core\City;
interface Repository{
public function add(CityResource $resource);
public function findByCity(City $city);

}