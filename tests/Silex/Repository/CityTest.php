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

    private function createDummyCity() {
        $user = $this->userRepository->findOneByUsername('TestUser');
        $city = $this->cityRepository->create(1, 'TestCity', $user, 1, 1);
        $this->cityRepository->add($city);
        $this->cityRepository->sync();
    }

    public function setUp() {
        $env = 'develop';
        $app                  = require __DIR__ . '/../../../bootstrap.php';
        $this->userRepository = new UserRepository($app['db']);
        $this->cityRepository = new CityRepository($app['db']);
        $this->createDummyUser();
        $this->createDummyCity();
    }

    public function testCityIsCreated() {
        $city = $this->cityRepository->findByLocation(1, 1);
        $this->assertInstanceOf('\OpenTribes\Core\Entity\City', $city);
    }

    public function tearDown() {
        $this->deleteDummyUser();
    }

}
