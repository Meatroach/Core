<?php

namespace OpenTribes\Core\Mock\Building\BuildTime;
use OpenTribes\Core\Building\BuildTime\Repository as BuildingBuildTimeRepositoryInterface;
use OpenTribes\Core\Building\BuildTime;

class Repository implements BuildingBuildTimeRepositoryInterface{
    private $buildBuildTimes = array();
    public function add(BuildTime $buildTime) {
        $this->buildBuildTimes[]=$buildTime;
    }
    public function findAll() {
        return $this->buildBuildTimes;
    }
    public function findByName($name) {
        ;
    }
}