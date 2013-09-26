<?php
namespace OpenTribes\Core\Building;
use OpenTribes\Core\Entity;
use OpenTribes\Core\Building;
class BuildTime extends Entity{
    private $time;
    private $factor;
    private $building;
    public function setTime(\DateTime $time){
        //TODO: Maybe DateTime..
        $this->time = $time;
        return $this;
    }
    public function setFactor($factor){
        $this->factor = (double) $factor;
        return $this;
    }
    public function setBuilding(Building $building){
        $this->building = $building;
        return $this;
    }
}