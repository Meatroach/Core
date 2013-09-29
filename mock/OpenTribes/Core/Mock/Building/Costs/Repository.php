<?php
namespace OpenTribes\Core\Mock\Building\Costs;
use OpenTribes\Core\Building\Costs\Repository as BuildingCostsRepositoryInterface;
use OpenTribes\Core\Building\Costs as BuildingCosts;
class Repository implements BuildingCostsRepositoryInterface{
    private $buildingCosts = array();
    public function add(BuildingCosts $costs) {
        $this->buildingCosts[]=$costs;
    }
    public function findAll() {
        return $this->buildingCosts;
    }
}