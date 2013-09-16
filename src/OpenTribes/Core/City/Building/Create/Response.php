<?php

namespace OpenTribes\Core\City\Building\Create;
use OpenTribes\Core\Building;
class Response{
    protected $building;
    public function __construct(Building $building) {
        $this->setBuilding($building);
    }
    public function setBuilding(Building $building){
        $this->building;
        return $this;
    }
    public function getBuilding(){
        return $this->building;
    }
}