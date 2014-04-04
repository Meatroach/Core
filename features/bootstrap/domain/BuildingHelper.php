<?php

use OpenTribes\Core\Repository\Building as BuildingRepository;

class BuildingHelper {

    private $buildingRepository;

    public function __construct(BuildingRepository $buildingRepository) {
        $this->buildingRepository = $buildingRepository;
    }

    /**
     * @param integer $minimumLevel
     * @param integer $maximumLevel
     */
    public function createDummyBuilding($name,$minimumLevel,$maximumLevel){
        $buildingId = $this->buildingRepository->getUniqueId();
        $building = $this->buildingRepository->create($buildingId, $name, $minimumLevel, $maximumLevel);
        $this->buildingRepository->add($building);
    }
}
