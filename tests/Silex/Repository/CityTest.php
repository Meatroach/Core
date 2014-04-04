<?php

namespace OpenTribes\Core\Test\Silex\Repository;

use OpenTribes\Core\Silex\Repository\DBALCity as CityRepository;
use OpenTribes\Core\Silex\Repository\DBALUser as UserRepository;

/**
 * Description of CityTest
 *
 * @author Witali
 */
class CityTest extends \PHPUnit_Framework_TestCase {

    private $userRepository;
    private $cityRepository;

    private function createDummyUser() {
        $user = $this->userRepository->create(1, 'TestUser', '123456', 'test@test.de');
        $this->userRepository->add($user);
        $this->userRepository->sync();
    }

    private function deleteDummyUser() {
        $user = $this->userRepository->findOneByUsername('TestUser');
        $this->userRepository->delete($user);
        $this->userRepository->sync();
    }

    private function deleteDummyCities() {
        $owner  = $this->userRepository->findOneByUsername('TestUser');
        $cities = $this->cityRepository->findAllByOwner($owner);

        foreach ($cities as $city) {
            $this->cityRepository->delete($city);
        }
        $this->cityRepository->sync();
    }

    private function createDummyCities() {
        $user = $this->userRepository->findOneByUsername('TestUser');
        for ($y = 0; $y < 5; $y++) {
            for ($x = 0; $x < 5; $x++) {
                $cityId = $this->cityRepository->getUniqueId();
                $city   = $this->cityRepository->create($cityId, 'TestCity' . $y . $x, $user, $y, $x);
                $this->cityRepository->add($city);
            }
        }

        $this->cityRepository->sync();
    }

    public function testFindCityByOwner() {
        $owner  = $this->userRepository->findOneByUsername('TestUser');
        $cities = $this->cityRepository->findAllByOwner($owner);
        $this->assertTrue(is_array($cities));
        foreach ($cities as $city) {
            $this->assertInstanceOf('\OpenTribes\Core\Entity\City', $city);
        }
    }

    public function setUp() {
        $env                  = 'develop';
        $app                  = require __DIR__ . '/../../../bootstrap.php';
        $this->userRepository = new UserRepository($app['db']);
        $this->cityRepository = new CityRepository($app['db']);
        $this->createDummyUser();
        $this->createDummyCities();
    }

    public function testCityIsCreated() {
        $city = $this->cityRepository->findByLocation(1, 1);
        $this->assertInstanceOf('\OpenTribes\Core\Entity\City', $city);
    }

    public function tearDown() {
        $this->deleteDummyCities();
        $this->deleteDummyUser();
    }

}
