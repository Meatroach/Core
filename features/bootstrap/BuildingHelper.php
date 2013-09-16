<?php

use OpenTribes\Core\Building\Mock\Repository as BuildingRepository;
use OpenTribes\Core\Resource\Mock\Repository as ResourceRepository;
use OpenTribes\Core\Building;
use OpenTribes\Core\Resource;
use OpenTribes\Core\Techtree;
class BuildingHelper{
    protected $exception;
    protected $buildingRepository;
    protected $resourceRepository;
    protected $techTree;
    public function __construct(ExceptionHelper $exception) {
        $this->exception = $exception;
        $this->buildingRepository = new BuildingRepository();
        $this->resourceRepository = new ResourceRepository();
        $this->techTree = new Techtree();
    }
    public function createDumbBuildings(array $data){
        foreach($data as $row){
            $building = new Building();
            $building->setId($row['id']);
            $building->setName($row['name']);
            $this->buildingRepository->add($building);
        }
    }
    public function getBuildingRepository(){
        return $this->buildingRepository;
    }
    public function getResourceRepository(){
        return $this->resourceRepository;
    }
    public function getTechTree(){
        return $this->techTree;
    }

    public function createTechtree(array $data){
     
         
        foreach($data as $row){
            $building = $this->buildingRepository->findByName($row['building']);
        
            $require = $this->buildingRepository->findByName($row['require']);
            
            $this->techTree->addRequirements($building, $require, $row['level']);
              
        }
       
    }
    public function createResources(array $resources){
        foreach($resources as $row){
          $resource = new Resource();
            $resource->setId($row['id'])
                    ->setName($row['name']);
            $this->resourceRepository->add($resource);
        }
    }
}