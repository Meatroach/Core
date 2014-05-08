<?php

namespace OpenTribes\Core\Test\Silex\Interactor;

use OpenTribes\Core\Context\Player\CreateNewCity as CreateNewCityInteractor;
use OpenTribes\Core\Request\CreateNewCity as CreateNewCityRequest;
use OpenTribes\Core\Response\CreateNewCity as CreateNewCityResponse;
use OpenTribes\Core\Silex\Repository;
use OpenTribes\Core\Silex\Service;
use OpenTribes\Core\Value\Direction;

class CityTest extends \PHPUnit_Framework_TestCase {

    private $cityRepository;
    private $mapTilesRepository;

    /**
     * @var \OpenTribes\Core\Silex\Repository\DBALUser; 
     */
    private $userRepository;
    private $locationCalculator;

    public function setUp() {
        $env = 'test';
        $app = require __DIR__ . '/../../../bootstrap.php';

        $this->cityRepository     = $app[Repository::CITY];
        $this->mapTilesRepository = $app[Repository::MAP_TILES];
        $this->userRepository     = $app[Repository::USER];
        $this->locationCalculator = $app[Service::LOCATION_CALCULATOR];
        $this->createDummyUser();
    }

    private function createDummyUser() {
        $user = $this->userRepository->create(1, 'Test', '123456', 'test@test.de');
        $this->userRepository->add($user);
    }

    public function testCreateRandomUniqueCities() {


        $interactor = new CreateNewCityInteractor($this->cityRepository, $this->mapTilesRepository, $this->userRepository, $this->locationCalculator);
        $response   = new CreateNewCityResponse;
        $locations  = array();
        for ($i = 0; $i < 20; $i++) {
            $request          = new CreateNewCityRequest('Test', Direction::ANY, 'TestCity ' . $i);
            $response->failed = $interactor->process($request, $response);
            $y                = $response->city->y;
            $x                = $response->city->x;
            $key              = sprintf('%d-%d', $y, $x);
            $this->assertFalse(isset($locations[$key]),sprintf('City at location Y:%d X:%d already exists',$y,$x));
            $locations[$key]  = array(
                'x' => $x,
                'y' => $y,
                'i' => $i
            );

            $this->assertNotNull($response->city);
        }
       
    }

}
