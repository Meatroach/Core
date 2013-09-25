<?php

namespace OpenTribes\Core\Building\Mock;
use OpenTribes\Core\Building\Repository as BuildingRepositoryInterface;
use OpenTribes\Core\Building;
class Repository implements BuildingRepositoryInterface{
    private $data;
    public function add(Building $building) {
        $this->data[$building->getName()] = $building;
    }
    public function findById($id) {
     
    }
    public function findByName($name) {
         return isset($this->data[$name]) ?$this->data[$name]:null;
    }
    public function findAll() {
        return $this->data;
    }
}