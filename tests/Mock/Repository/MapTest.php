<?php

namespace OpenTribes\Core\Test\Mock\Repository;

use OpenTribes\Core\Mock\Repository\Map as MapRepository;
use OpenTribes\Core\Mock\Repository\Tile as TileRepository;

class MapTest extends \PHPUnit_Framework_TestCase {

    private $mapRepository;
    private $tileRepository;

    public function setUp() {
        $this->mapRepository  = new MapRepository();
        $this->tileRepository = new TileRepository();
        $mapId                = $this->mapRepository->getUniqueId();
        $map                  = $this->mapRepository->create($mapId, 'TestMap');
        $tileId               = $this->tileRepository->getUniqueId();
        $tile                 = $this->tileRepository->create($tileId, 'TestAccessibleTile', true);
        $map->addTile($tile, "0", "0");
        $tileId               = $this->tileRepository->getUniqueId();
        $tile                 = $this->tileRepository->create($tileId, 'TestNotAccessibleTile', false);
        $map->addTile($tile, "1", "1");

        $this->mapRepository->add($map);
    }
    public function testFindAccessableTile() {
        $map = $this->mapRepository->findOneByName('TestMap');
        $this->assertTrue($map->isAccessible("0", "0"));
    }

    public function testFindNotAccessableTile() {
        $map = $this->mapRepository->findOneByName('TestMap');
        $this->assertFalse($map->isAccessible("1", "1"));
    }

}
