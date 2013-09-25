<?php

namespace OpenTribes\Core\City;

use OpenTribes\Core\Entity;
use OpenTribes\Core\City;
use OpenTribes\Core\Building as BaseBuilding;
class Building extends Entity {

    protected $level;
    protected $building;
    protected $city;
    public function setLevel($level){
        $this->level = (int)$level;
        return $this;
    }
  

    public function setBuilding(BaseBuilding $building){
        $this->building = $building;
        return $this;
    }
    public function setCity(City $city){
        $this->city = $city;
        return $this;
    }
    public function getLevel(){
        return $this->level;
    }

    public function getBuilding(){
        return $this->building;
    }
    public function getCity(){
        return $this->city;
    }

}