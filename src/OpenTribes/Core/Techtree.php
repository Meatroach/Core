<?php
namespace OpenTribes\Core;
use OpenTribes\Core\Building;

class Techtree extends Entity{
    protected $requirements = array();
    public function addRequirements(Building $building, Building $require = null,$level = null){
        $this->requirements[$building->getName()][]=array('building'=>$require,'level'=>$level);
    }
    public function canBuild(Building $building,array $cityBuildings){
        if(!isset($this->requirements[$building->getName()])) return true;
        $requirements = $this->requirements[$building->getName()];
        $fullfill = 0;
        foreach($requirements as $row){
            
            foreach($cityBuildings as $cityBuilding){
                if($row['building'] === $cityBuilding->getBuilding()&&
                        $row['level']<= $cityBuilding->getLevel()){
                    $fullfill++;
                }
            }
           
        }
        return $fullfill == count($requirements);
    }
}
