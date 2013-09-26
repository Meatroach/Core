<?php

use OpenTribes\Core\Building\Mock\Repository as BuildingRepository;
use OpenTribes\Core\Resource\Mock\Repository as ResourceRepository;
use OpenTribes\Core\Building\Costs\Mock\Repository as BuildingCostsRepository;
use OpenTribes\Core\Building\BuildTime\Mock\Repository as BuildTimeRepository;
use OpenTribes\Core\Building;
use OpenTribes\Core\Resource;
use OpenTribes\Core\Techtree;
use OpenTribes\Core\Building\Costs as BuildingCosts;
use OpenTribes\Core\Building\BuildTime;
class BuildingHelper {

    protected $exception;
    protected $buildingRepository;
    protected $resourceRepository;
    protected $techTree;
    protected $buildingCostsRepository;
    protected $buildTimeRepository;
    public function __construct(ExceptionHelper $exception) {
        $this->exception = $exception;
        $this->buildingRepository = new BuildingRepository();
        $this->buildingCostsRepository = new BuildingCostsRepository();
        $this->resourceRepository = new ResourceRepository();
        $this->buildTimeRepository = new BuildTimeRepository();
        $this->techTree = new Techtree();
    }

    public function createDumbBuildings(array $data) {
        foreach ($data as $row) {
            $building = new Building();
            foreach ($row as $field => $value) {
                $building->{$field} = $value;
            }

            $this->buildingRepository->add($building);
        }
    }

    public function getBuildingRepository() {
        return $this->buildingRepository;
    }

    public function getResourceRepository() {
        return $this->resourceRepository;
    }

    public function getTechTree() {
        return $this->techTree;
    }

    public function createTechtree(array $data) {


        foreach ($data as $row) {
            $building = $this->buildingRepository->findByName($row['building']);

            $require = $this->buildingRepository->findByName($row['require']);

            $this->techTree->addRequirements($building, $require, $row['level']);
        }
    }

    public function createResources(array $resources) {

        foreach ($resources as $row) {
            $resource = new Resource();

            foreach ($row as $field => $value) {
                $resource->{$field} = $value;
            }

            $this->resourceRepository->add($resource);
        }
    }

    public function setBuildingCosts(array $costs) {

        foreach ($costs as $row) {

            $buildingCosts = new BuildingCosts();

            $row['building'] = $this->buildingRepository->findByName($row['building']);
            $row['resource'] = $this->resourceRepository->findByName($row['resource']);


            foreach ($row as $field => $value) {
                $buildingCosts->{$field} = $value;
            }
            $this->buildingCostsRepository->add($buildingCosts);
        }
      
    }
    public function setBuildingBuildTimes(array $buildTimes){
          foreach ($buildTimes as $row) {

            $buildTime = new BuildTime();

            $row['building'] = $this->buildingRepository->findByName($row['building']);
            $time = new DateTime();
            $row['time'] = $time->setTimestamp($row['time']);


            foreach ($row as $field => $value) {
                $buildTime->{$field} = $value;
            }
            $this->buildTimeRepository->add($buildTime);
        }
    }

}