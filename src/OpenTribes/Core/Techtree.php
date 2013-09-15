<?php
namespace OpenTribes\Core;
use OpenTribes\Core\Building;
use OpenTribes\Core\City;
class Techtree extends Entity{
    protected $requirements = array();
    public function addRequirements(Building $building, Building $require = null,$level = null){
        $this->requirements[$building->getName()][]=array($require,$level);
    }
    public function canBuild(Building $building,City $city){
        if(!isset($this->requirements[$building->getName()])) return true;
        $requirements = $this->requirements[$building->getName()];
        $buildings = $city->getBuildings();
        foreach($requirements as $row){
            foreach($row as $building){
                
            }
        }
    }
}
