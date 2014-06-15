<?php

namespace OpenTribes\Core\Test\Silex\Repository;

use Exception;
use OpenTribes\Core\Silex\Repository;
use PHPUnit_Framework_TestCase;

/**
 * Description of CityTest
 *
 * @author Witali
 */
class CityTest extends PHPUnit_Framework_TestCase
{

    private $userRepository;
    private $cityRepository;

    private function createDummyUser()
    {
        $userId = $this->userRepository->getUniqueId();
        $user = $this->userRepository->create($userId, 'TestUser', '123456', 'test@test.de');
        $this->userRepository->add($user);
       
    }

    private function deleteDummyUser()
    {
        $user = $this->userRepository->findOneByUsername('TestUser');
        if (!$user) {
            throw new Exception("Could not delete Dummy User");
        }
        $this->userRepository->delete($user);
 
    }

    private function deleteDummyCities()
    {
        $owner = $this->userRepository->findOneByUsername('TestUser');
        if (!$owner) {
            throw new Exception("Could not delete Dummy Cities, owner not found");
        }
        $cities = $this->cityRepository->findAllByOwner($owner);

        foreach ($cities as $city) {
            $this->cityRepository->delete($city);
        }
     
    }

    private function createDummyCities()
    {
        $user = $this->userRepository->findOneByUsername('TestUser');
        if (!$user) {
            throw new Exception("User not found");
        }
        for ($y = 0; $y < 5; $y++) {
            for ($x = 0; $x < 5; $x++) {
                $cityId = $this->cityRepository->getUniqueId();
                $name   = sprintf('TestCity%d%d', $y, $x);
                $city   = $this->cityRepository->create($cityId, $name, $y, $x);
                $city->setOwner($user);
                $this->cityRepository->add($city);
            }
        }

     
    }

    public function testFindCityByOwner()
    {
        $owner = $this->userRepository->findOneByUsername('TestUser');
        if (!$owner) {
            throw new Exception("User not found");
        }
        $cities = $this->cityRepository->findAllByOwner($owner);
        $this->assertTrue(is_array($cities));
        foreach ($cities as $city) {
            $this->assertInstanceOf('\OpenTribes\Core\Entity\City', $city);
        }
    }

    public function setUp()
    {
        $env                  = 'test';
        $app                  = require __DIR__ . '/../../../bootstrap.php';
        $this->userRepository = $app[Repository::USER];
        $this->cityRepository = $app[Repository::CITY];
        $this->createDummyUser();
        $this->createDummyCities();
    }

    public function testFindCityByLocation()
    {
        $city = $this->cityRepository->findByLocation(1, 1);
        $this->assertInstanceOf('\OpenTribes\Core\Entity\City', $city);
    }

    public function tearDown()
    {
        $this->deleteDummyCities();
        $this->deleteDummyUser();
    }

}