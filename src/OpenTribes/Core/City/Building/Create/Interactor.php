<?php

namespace OpenTribes\Core\City\Building\Create;
use OpenTribes\Core\City\Building\Repository as CityBuildingRepository;
use OpenTribes\Core\Building\Repository as BuildingRepository;
use OpenTribes\Core\Techtree;
use OpenTribes\Core\City\Building\Create\Exception\CannotBuild as CannotBuildException;
use OpenTribes\Core\City\Building\Create\Exception\NotFound as BuildingNotFoundException;
class Interactor{
    protected $cityBuildingRepository;
    protected $buildingRepository;
    protected $techTree;
    protected $calculator;
    protected $cityBuildingQueueRepository;
    public function __construct(
            CityBuildingRepository $cityBuildingRepo,
            BuildingRepository $buildingRepo,
            ResourceRepository $resourceRepo,
            CityResourceRepository $cityResourceRepo,
            CityBuildingQueueRepository $cityBuildingQueueRepo,
            Techtree $techtree,
            CostsCalculator $calculator
            ) {
        $this->cityBuildingRepository = $cityBuildingRepo;
        $this->buildingRepository = $buildingRepo;
        $this->techTree = $techtree;
        $this->calculator = $calculator;
        $this->cityBuildingQueueRepository = $this->cityBuildingQueueRepo;
    }
    public function __invoke(Request $request) {
        $building = $this->buildingRepository->findByName($request->getBuildingName());
        if(!$building) throw new BuildingNotFoundException();
        
        $buildings = $this->cityBuildingRepository->findBuildingsByCity($request->getCity());
        
        $this->techTree->setBuildings($buildings);
        if(!$this->techTree->canBuild($building)) throw new CannotBuildException();
        
        $resources = $this->cityResourceRepository->findResourceByCity($request->getCity());
        $this->calculator->setResources($resources);
        if(!$this->calculator->hasEnoughtResources())
        
        return new Response($building);
       
    }
}
