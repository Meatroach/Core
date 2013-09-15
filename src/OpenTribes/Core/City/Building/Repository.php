<?php
namespace OpenTribes\Core\City\Building;


use OpenTribes\Core\City\Building as CityBuilding;
interface Repository{
public function add(CityBuilding $building);
public function findByBuildingName($name);
public function findByCityName($name);
}
