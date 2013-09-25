<?php
namespace OpenTribes\Core\City\Building;


use OpenTribes\Core\City\Building as CityBuilding;
use OpenTribes\Core\City;
interface Repository{
public function add(CityBuilding $building);
public function findByBuildingName($name);
public function findByCityName($name);
public function findBuildingsByCity(City $city);
public function findAll();
}
