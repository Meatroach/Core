<?php

namespace OpenTribes\Core\Test\Mock\Repository;

use OpenTribes\Core\Mock\Repository\City as CityRepository;
use OpenTribes\Core\Mock\Repository\User as UserRepository;
class CityTest extends \PHPUnit_Framework_TestCase {

    private $cityRepository;
    private $userRepository;
    public function setUp() {
        $this->cityRepository = new CityRepository();
        $this->userRepository = new UserRepository();
        
        $userId = $this->userRepository->getUniqueId();
        $user = $this->userRepository->create($userId, 'TestUser', '123456', 'test@test.de');
                
        $cityId = $this->cityRepository->getUniqueId();
        $city = $this->cityRepository->create($cityId, 'TestCity', $user, "0", "0");
        $this->cityRepository->add($city);
    }
    public function testCityExistsAtLocation(){
        $this->assertTrue($this->cityRepository->cityExistsAt("0", "0"));
    }
    public function testCityNotExistsAtLocation(){
        $this->assertFalse($this->cityRepository->cityExistsAt("1", "0"));
    }
}