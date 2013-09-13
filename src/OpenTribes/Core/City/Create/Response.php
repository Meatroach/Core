<?php
namespace OpenTribes\Core\City\Create;
use OpenTribes\Core\City;
class Response{
    protected $city;
    public function __construct($city) {
       $this->setCity($city);
    }
    public function setCity(City $city){
        $this->city = $city;
        return $this;
    }
    public function getCity(){
        return $this->city;
    }
}
