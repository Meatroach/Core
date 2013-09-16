<?php

namespace OpenTribes\Core\City;

use OpenTribes\Core\Entity;
use OpenTribes\Core\City;
use OpenTribes\Core\Resource as BaseResource;
class Resource extends Entity{
    protected $amount;
    protected $city;
    protected $resource;
    public function setAmount($amount){
        $this->amount = (int) $amount;
        return $this;
    }
    public function getAmount(){
        return $this->amount;
    }
    public function setCity(City $city){
        $this->city = $city;
        return $this;
    }
    public function setResource(BaseResource $resource){
        $this->resource = $resource;
        return $this;
    }
}
