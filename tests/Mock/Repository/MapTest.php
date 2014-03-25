<?php

use OpenTribes\Core\Mock\Repository\Map as MapRepository;
use OpenTribes\Core\Mock\Repository\Tile as TileRepository;

class MapTest extends PHPUnit_Framework_TestCase {

    private $mapRepository;
    private $tileRepository;

    public function setUp() {
        $this->mapRepository  = new MapRepository();
        $this->tileRepository = new TileRepository();
        $map                  = $this->mapRepository->create('TestMap');
        $tileId               = $this->tileRepository->getUniqueId();
        $tile                 = $this->tileRepository->create($tileId, 'TestAccessibleTile', true);
        $map->addTile($tile, "0", "0");
        $tileId               = $this->tileRepository->getUniqueId();
        $tile                 = $this->tileRepository->create($tileId, 'TestNotAccessibleTile', false);
        $map->addTile($tile, "1", "1");

        $this->mapRepository->add($map);
    }

    public function testFindAccessableTile() {

     
        $this->assertTrue($this->mapRepository->tileIsAccessible("0", "0"));
    }

    public function testFindNotAccessableTile() {


        $this->assertFalse($this->mapRepository->tileIsAccessible("1", "1"));
    }

}
