<?php
namespace OpenTribes\Core\Map\City;
use OpenTribes\Core\Map\City as MapCity;
interface Repository{
public function add(MapCity $mapCity);
public function findByLocation($x,$y);
}