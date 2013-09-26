<?php

namespace OpenTribes\Core\Building;
use OpenTribes\Core\Entity;
use OpenTribes\Core\Building;
use OpenTribes\Core\Resource;
class Costs extends Entity{
    private $building;
    private $resource;
    private $value;
    private $factor;
    public function setBuilding(Building $building){
        $this->building = $building;
        return $this;
    }
    public function setResource(Resource $resource){
        $this->resource = $resource;
        return $this;
    }
    public function setValue($value){
        $this->value = (int) $value;
        return $this;
    }
    public function setFactor($factor){
        $this->factor = (double) $factor;
        return $this;
    }
    public function getBuilding(){
        return $this->building;
    }
    public function getResource(){
        return $this->resource;
    }
    public function getValue(){
        return $this->value;
    }
    public function getFactor(){
        return $this->factor;
    }
}
