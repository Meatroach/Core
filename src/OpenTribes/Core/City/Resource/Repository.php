<?php
namespace OpenTribes\Core\City\Resource;
use OpenTribes\Core\City\Resource as CityResource;
interface Repository{
public function add(CityResource $resource);
}