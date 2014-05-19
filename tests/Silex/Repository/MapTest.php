<?php

namespace OpenTribes\Core\Test\Silex\Repository;

use OpenTribes\Core\Silex\Repository;

/**
 * Description of MapTest
 *
 * @author BlackScorp<witalimik@web.de>
 */
class MapTest extends \PHPUnit_Framework_TestCase {

    /**
     *
     * @var \OpenTribes\Core\Silex\Repository\DBALMap
     */
    private $mapRepository;

    /**
     *
     * @var \OpenTribes\Core\Silex\Repository\DBALCity
     */
    private $cityRepository;

    /**
     *
     * @var \OpenTribes\Core\Silex\Repository\DBALUser 
     */
    private $userRepository;

    /**
     *
     * @var \OpenTribes\Core\Silex\Repository\DBALTile 
     */
    private $tileRepository;
    private $mapOptions;

    public function setUp() {
        $env                  = 'test';
        $app                  = require __DIR__ . '/../../../bootstrap.php';
        $this->mapRepository  = $app[Repository::MAP];
        $this->cityRepository = $app[Repository::CITY];
        $this->userRepository = $app[Repository::USER];
        $this->tileRepository = $app[Repository::TILE];
        $this->mapOptions     = $app['map.options'];
        $this->createDummyMap();
        $this->createDummyUser();
        $this->createDummyCity();
        $this->createDummyTiles();
    }

    private function createDummyMap() {
        $mapId = $this->mapRepository->getUniqueId();
        $map   = $this->mapRepository->create($mapId, 'Dummy');
        $map->setWidth($this->mapOptions['width']);
        $map->setHeight($this->mapOptions['height']);
        $this->mapRepository->add($map);
    }

    private function createDummyTiles() {
        $map    = $this->mapRepository->findOneByName('Dummy');
        $tileId = $this->tileRepository->getUniqueId();
        $tile   = $this->tileRepository->create($tileId, 'Accessible', true);
        $map->addTile($tile, 51, 50);
        $this->tileRepository->add($tile);
        $tileId = $this->tileRepository->getUniqueId();
        $tile   = $this->tileRepository->create($tileId, 'NotAccessible', false);
        $map->addTile($tile, 50, 51);
        $this->tileRepository->add($tile);
        
    }

    private function createDummyUser() {
        $userId = $this->userRepository->getUniqueId();
        $user   = $this->userRepository->create($userId, 'Test', '1234', 'test@test.de');
        $this->userRepository->add($user);
    }

    private function createDummyCity() {

        $owner  = $this->userRepository->findOneByUsername('Test');
        if(!$owner) throw new Exception ('User not exists');
        $cityId = $this->cityRepository->getUniqueId();
        $city   = $this->cityRepository->create($cityId, 'Test 1', 50, 50);
        $city->setOwner($owner);
        $this->cityRepository->add($city);
    }

    private function deleteDummyMap() {
        $map = $this->mapRepository->findOneByName('Dummy');

        $this->mapRepository->delete($map);
    }

    public function testCityExistsAtLocation() {
        $this->assertTrue($this->cityRepository->cityExistsAt(50, 50));
    }

    public function testCityNotExistsAtLocation() {
        $this->assertFalse($this->cityRepository->cityExistsAt(49, 50));
    }

    public function testTileAccessibleAtLocation() {
        $map = $this->mapRepository->findOneByName('Dummy');
        $this->assertTrue($map->isAccessible(51, 50));
    }

    public function testTileNotAccessibleAtLocation() {
        $map = $this->mapRepository->findOneByName('Dummy');
        $this->assertFalse($map->isAccessible(50, 51));
    }

    public function testCanCreateDummyMap() {

        $this->mapRepository->sync();
    }

    public function testCanLoadDummyMap() {

        $map = $this->mapRepository->findOneByName('Dummy');
        $this->assertInstanceOf('\OpenTribes\Core\Entity\Map', $map);
    }

    public function tearDown() {
        $this->deleteDummyMap();
        $this->mapRepository->sync();
    }

}
