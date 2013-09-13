<?php

namespace OpenTribes\Core\City\Create;

use OpenTribes\Core\User;
class Request{
    protected $x;
    protected $y;
    protected $user;
    protected $cityName;
    public function __construct(User $user,$x,$y,$cityName) {
        $this->setUser($user)
                ->setX($x)
                ->setY($y)
                ->setCityName($cityName);
    }
    public function setUser(User $user){
        $this->user = $user;
        return $this;
    }
    public function getUser(){
        return $this->user;
    }

    public function setX($x){
        $this->x = (int)$x;
        return $this;
    }
    public function setCityName($cityName){
        $this->cityName = $cityName;
        return $this;
    }

    public function setY($y){
        $this->y = (int)$y;
        return $this;
    }
    public function getX(){
        return $this->x;
    }
    public function getY(){
        return $this->y;
    }
    public function getCityName(){
        return $this->cityName;
    }
}
