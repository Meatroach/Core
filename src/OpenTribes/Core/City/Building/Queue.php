<?php
namespace OpenTribes\Core\City\Building;
use OpenTribes\Core\User;
use OpenTribes\Core\Entity;
use OpenTribes\Core\City\Building as CityBuilding;
use OpenTribes\Core\Interactor;
class Queue extends Entity{
    protected $cityBuilding;
    protected $actionEnd;
    protected $action;
    protected $user;
    public function setCityBuilding(CityBuilding $cityBuilding){
        $this->cityBuilding = $cityBuilding;
        return $this;
    }
    public function setActionEnd(\DateTime $end){
        $this->actionEnd = $end;
        return $this;
    }
    public function setAction(Interactor $action){
        $this->action = $action;
        return $this;
    }
    public function setUser(User $user){
        $this->user = $user;
        return $this;
    }
}