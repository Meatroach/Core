<?php

use OpenTribes\Core\City;
use OpenTribes\Core\City\Mock\Repository as CityRepository;
use OpenTribes\Core\User\Mock\Repository as UserRepository;
use OpenTribes\Core\City\Create\Request as CityCreateRequest;
use OpenTribes\Core\City\Create\Interactor as CityCreateInteractor;

require_once 'vendor/phpunit/phpunit/PHPUnit/Framework/Assert/Functions.php';

class CityHelper {

    protected $mapHelper;
    protected $userRepository;
    protected $cityRepository;
    protected $user;
    protected $response;
    protected $exception;
    protected $userHelper;
    public function __construct(ExceptionHelper $exception) {
        $this->mapHelper = new MapHelper();
        $this->cityRepository = new CityRepository();
        $this->exception = $exception;
    }

    public function getMapHelper() {
        return $this->mapHelper;
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

    public function assertHasCity() {

        assertNotNull($this->response);
        assertInstanceOf('OpenTribes\Core\City\Create\Response', $this->response);
        assertNotNull($this->response->getCity());
        assertSame($this->user, $this->response->getCity()->getOwner());
    }

}