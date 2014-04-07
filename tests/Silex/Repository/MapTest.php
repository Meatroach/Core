<?php

namespace OpenTribes\Core\Test\Silex\Repository;

use OpenTribes\Core\Silex\Repository\DBALMap as MapRepository;

/**
 * Description of MapTest
 *
 * @author BlackScorp<witalimik@web.de>
 */
class MapTest extends \PHPUnit_Framework_TestCase {

    private $mapRepository;

    public function setUp() {
        $env                 = 'test';
        $app                 = require __DIR__ . '/../../../bootstrap.php';
        $this->mapRepository = new MapRepository($app['db']);
        $this->createDummyMap();
    }

    private function createDummyMap() {
        $mapId = $this->mapRepository->getUniqueId();
        $map   = $this->mapRepository->create($mapId, 'Dummy');
        $map->setWidth(100);
        $map->setHeight(100);
        $this->mapRepository->add($map);
    }

    private function deleteDummyMap() {
        $map = $this->mapRepository->findOneByName('Dummy');
    
        $this->mapRepository->delete($map);
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
