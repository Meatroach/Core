<?php

use OpenTribes\Core\Repository\Building as BuildingRepository;

class BuildingHelper {

    private $buildingRepository;

    function __construct(BuildingRepository $buildingRepository) {
        $this->buildingRepository = $buildingRepository;
    }
    public function createDummyBuilding($name,$minimumLevel,$maximumLevel){
        $buildingId = $this->buildingRepository->getUniqueId();
        $building = $this->buildingRepository->create($buildingId, $name, $minimumLevel, $maximumLevel);
        $this->buildingRepository->add($building);
    }
}
