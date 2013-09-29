<?php
namespace OpenTribes\Core\Mock\Building;

use OpenTribes\Core\Building\Repository as BuildingRepositoryInterface;
use OpenTribes\Core\Building;
class Repository implements BuildingRepositoryInterface{
    private $buildings = array();
    public function add(Building $building) {
        $this->buildings[$building->getName()] = $building;
    }
    public function findAll() {
        return $this->buildings;
    }
    public function findByName($name) {
        return isset($this->buildings[$name]) ? $this->buildings[$name]:null;
    }
}