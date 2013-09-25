<?php

namespace OpenTribes\Core\City\Resource\Mock;
use OpenTribes\Core\City\Resource\Repository as CityResourceRepository;
use OpenTribes\Core\City\Resource as CityResource;
class Repository implements CityResourceRepository{
    private $data = array();
    public function add(CityResource $resource) {
        $this->data[$resource->getResource()->getName()] = $resource;
    }
}