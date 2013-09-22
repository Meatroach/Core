<?php

namespace OpenTribes\Core\City;

use OpenTribes\Core\Entity;
use OpenTribes\Core\City;
use OpenTribes\Core\Building as BaseBuilding;
class Building extends Entity {

    protected $level;
    protected $maximumLevel;
    protected $minimumLevel;
    protected $building;
    protected $city;
    public function setLevel($level){
        $this->level = (int)$level;
        return $this;
    }
    public function setMaximumLevel($level){
        $this->maximumLevel = (int)$level;
        return $this;
    }
    public function setMinimumLevel($level){
        $this->minimumLevel = $level;
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
    public function getMaximumLevel(){
        return $this->maxiumumLevel;
    }
    public function getBuilding(){
        return $this->building;
    }
    public function getCity(){
        return $this->city;
    }
    public function getMinimumLevel(){
        return $this->minimumLevel;
    }
}