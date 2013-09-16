<?php
namespace OpenTribes\Core\City\Building\Create;

use OpenTribes\Core\City;

class Request{
    protected $buildingName;
    protected $city;
    public function __construct(City $city,$buildingName){
        $this->setBuildingName($buildingName)
                ->setCity($city);
    }
    public function setBuildingName($buildingName){
        $this->buildingName = $buildingName;
        return $this;
    }
    public function setCity(City $city){
        $this->city = $city;
        return $this;
    }
    public function getCity(){
        return $this->city;
    }
    public function getBuildingName(){
        return $this->buildingName;
    }
}