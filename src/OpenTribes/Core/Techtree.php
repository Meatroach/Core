<?php

namespace OpenTribes\Core;

use OpenTribes\Core\Building;

class Techtree extends Entity {

    protected $requirements = array();
    protected $buildings = array();

    public function addRequirements(Building $building, Building $require = null, $level = null) {
        $this->requirements[$building->getName()][] = array('building' => $require, 'level' => $level);
    }

    public function setBuildings(array $buildings) {

        foreach ($buildings as $building) {

            $this->buildings[$building->getBuilding()->getName()] = $building;
        }
    }

    public function canBuild(Building $building) {
        //no requirements so you can build it
        if (!isset($this->requirements[$building->getName()]))
            return true;

        $requirements = $this->requirements[$building->getName()];
      
        
        foreach ($requirements as $row) {
            $buildingName = $row['building']->getName();
            if (isset($this->buildings[$buildingName]) &&
                    $row['level'] > $this->buildings[$buildingName]->getLevel()
            ) {
                return false;
            }
        }
        return true;
    }

}
