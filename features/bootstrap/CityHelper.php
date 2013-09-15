<?php

use OpenTribes\Core\City;
use OpenTribes\Core\City\Building as CityBuilding;
use OpenTribes\Core\City\Mock\Repository as CityRepository;
use OpenTribes\Core\User\Mock\Repository as UserRepository;
use OpenTribes\Core\City\Building\Mock\Repository as CityBuildingRepository;
use OpenTribes\Core\City\Create\Request as CityCreateRequest;
use OpenTribes\Core\City\Create\Interactor as CityCreateInteractor;
use OpenTribes\Core\Building\Mock\Repository as BuildingRepository;
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
    public function __construct(ExceptionHelper $exception) {
        $this->mapHelper = new MapHelper();
        $this->cityRepository = new CityRepository();
        $this->exception = $exception;
        $this->cityBuildingRepository = new CityBuildingRepository();
    }
    public function setBuildingRepo(BuildingRepository $repo){
        $this->buildingRepository = $repo;
    }

    public function getMapHelper() {
        return $this->mapHelper;
    }
    public function getCity(){
        return $this->city;
    }

    public function setUserRepository(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function createCities(array $cities) {
        foreach ($cities as $row) {
            $city = new City();
            $user = $this->userRepository->findByUsername($row['owner']);
            $city->setId($row['id']);
            $city->setX($row['x']);
            $city->setY($row['y']);
            $city->setOwner($user);
            $this->cityRepository->add($city);
        }
       
    }
    public function assignBuildingsToCity(array $buildings){
        foreach($buildings as $row){
            $building = $this->buildingRepository->findByName($row['name']);
            $cityBuilding = new CityBuilding();
            $cityBuilding->setId($row['id']);
            $cityBuilding->setBuilding($building);
            $cityBuilding->setCity($this->city);
            $cityBuilding->setLevel($row['level']);
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
    public function assignDumpCity(){
        $this->city = $this->cityRepository->findByUser($this->user);
    }
    
    public function assertHasCity() {

        assertNotNull($this->response);
        assertInstanceOf('OpenTribes\Core\City\Create\Response', $this->response);
        assertNotNull($this->response->getCity());
        assertSame($this->user, $this->response->getCity()->getOwner());
    }

}