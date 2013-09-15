<?php

namespace OpenTribes\Core\Building\Mock;
use OpenTribes\Core\Building\Repository as BuildingRepositoryInterface;
use OpenTribes\Core\Building;
class Repository implements BuildingRepositoryInterface{
    private $data;
    public function add(Building $building) {
        $this->data[$building->getId()] = $building;
    }
    public function findById($id) {
      return isset($this->data[$id]) ?$this->data[$id]:null;
    }
    public function findByName($name) {
        foreach($this->data as $building){
         
            if($building->getName() === $name) return $building;
        }
        return null;
    }
}