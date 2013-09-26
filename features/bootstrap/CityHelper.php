<?php

use OpenTribes\Core\City;
use OpenTribes\Core\City\Building as CityBuilding;
use OpenTribes\Core\City\Mock\Repository as CityRepository;
use OpenTribes\Core\User\Mock\Repository as UserRepository;
use OpenTribes\Core\City\Building\Mock\Repository as CityBuildingRepository;
use OpenTribes\Core\City\Create\Request as CityCreateRequest;
use OpenTribes\Core\City\Create\Interactor as CityCreateInteractor;
use OpenTribes\Core\Building\Mock\Repository as BuildingRepository;
use OpenTribes\Core\Resource\Mock\Repository as ResourceRepository;
use OpenTribes\Core\City\Resource\Mock\Repository as CityResourceRepository;
use OpenTribes\Core\City\Resource as CityResource;
use OpenTribes\Core\Techtree;
use OpenTribes\Core\City\Building\Create\Request as CityBuildingCreateRequest;
use OpenTribes\Core\City\Building\Create\Interactor as CityBuildingCreateInteractor;

require_once 'vendor/phpunit/phpunit/PHPUnit/Framework/Assert/Functions.php';

class CityHelper {

    protected $mapHelper;
    protected $userRepository;
    protected $cityRepository;
    protected $user;
    protected $response;
    protected $exception;
    protected $userHelper;
    protected $city;
    protected $buildingRepository;
    protected $cityBuildingRepository;
    protected $resourceRepository;
    protected $cityResourceRepository;
    protected $techTree;

    public function __construct(ExceptionHelper $exception) {
        $this->mapHelper = new MapHelper();
        $this->cityRepository = new CityRepository();
        $this->exception = $exception;
        $this->cityBuildingRepository = new CityBuildingRepository();
        $this->cityResourceRepository = new CityResourceRepository();
    }

    public function setBuildingRepo(BuildingRepository $repo) {
        $this->buildingRepository = $repo;
    }

    public function setResourceRepo(ResourceRepository $repo) {
        $this->resourceRepository = $repo;
    }

    public function setTechTree(Techtree $techtree) {
        $this->techTree = $techtree;
    }

    public function getMapHelper() {
        return $this->mapHelper;
    }

    public function getCity() {
        return $this->city;
    }

    public function setUserRepository(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function createCities(array $cities) {
        foreach ($cities as $row) {
            $city = new City();
            $user = $this->userRepository->findByUsername($row['owner']);
            $row['owner'] = $user;
            foreach ($row as $field => $value) {
                $city->{$field} = $value;
            }
          
            
            $this->cityRepository->add($city);
        }
    }

    public function assignResourcesToCity(array $resources) {

        foreach ($resources as $row) {

            $resource = $this->resourceRepository->findByName($row['name']);
            $cityResource = new CityResource();
            $row['resource'] = $resource;
            $row['city'] = $this->city;
            foreach ($row as $field => $value) {
                $cityResource->{$field} = $value;
            }

            $this->cityResourceRepository->add($cityResource);
        }
    }

    public function assignBuildingsToCity(array $buildings) {
        foreach ($buildings as $row) {
            $building = $this->buildingRepository->findByName($row['name']);
            $cityBuilding = new CityBuilding();
            $row['building'] = $building;
            $row['city'] = $this->city;
              foreach ($row as $field => $value) {
                $cityBuilding->{$field} = $value;
            }
          
            $this->cityBuildingRepository->add($cityBuilding);
        }
    }

    public function iamUser($username) {
        $this->user = $this->userRepository->findByUsername($username);
    }

    public function create($x, $y) {
        $cityName = $this->user->getUsername() . "'s Village";

        $request = new CityCreateRequest($this->user, $x, $y, $cityName);
        $interactor = new CityCreateInteractor($this->cityRepository, $this->mapHelper->getMapTileRepository());
        try {

            $this->response = $interactor($request);
        } catch (\Exception $e) {
            $this->exception->setException($e);
        }
    }

    public function build($buildingName) {
        $request = new CityBuildingCreateRequest($this->city, $buildingName);
        $interactor = new CityBuildingCreateInteractor($this->cityBuildingRepository, $this->buildingRepository, $this->techTree);
        try {
            $this->reposne = $interactor($request);
        } catch (\Exception $e) {
            $this->exception->setException($e);
        }
    }

    public function assignDumpCity() {
        $this->city = $this->cityRepository->findByUser($this->user);
          foreach($this->buildingRepository->findAll() as $building){
                $cityBuilding  = new CityBuilding();
                $cityBuilding->setBuilding($building);
                $cityBuilding->setCity($this->city);
                $cityBuilding->setLevel($building->getMinimumLevel());
                $this->cityBuildingRepository->add($cityBuilding);
            }
    }

    public function assertHasCity() {

        assertNotNull($this->response);
        assertInstanceOf('OpenTribes\Core\City\Create\Response', $this->response);
        assertNotNull($this->response->getCity());
        assertSame($this->user, $this->response->getCity()->getOwner());
    }

}