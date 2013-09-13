<?php

use OpenTribes\Core\Tile\Mock\Repository as TileRepository;
use OpenTribes\Core\Entity\Factory as EntityFactory;
use OpenTribes\Core\Tile;
use OpenTribes\Core\Map\Tile\Mock\Repository as MapTileRepository;
use OpenTribes\Core\Map;
use OpenTribes\Core\Map\Tile as MapTile;
use OpenTribes\Core\Map\Mock\Repository as MapRepository;
class MapHelper {

    protected $tileRepository;
    protected $mapTileRepository;
    protected $mapRepository;

    public function __construct() {
        $this->tileRepository = new TileRepository();
        $this->mapTileRepository = new MapTileRepository();
        $this->mapRepository = new MapRepository();
    }
    public function getMapRepository(){
        return $this->mapRepository;
    }
    public function getMapTileRepository(){
        return $this->mapTileRepository;
    }

    public function createTiles(array $tiles) {
     
        $statsMapper = array(
            'yes'=>true,
            'no'=>false
        );
        foreach ($tiles as $tile) {
            $tileEntity = new Tile();
            $tileEntity->setId($tile['id']);
            $tileEntity->setName($tile['name']);
            $tileEntity->setAccessable($statsMapper[$tile['accessable']]);
            $this->tileRepository->add($tileEntity);
        }
    
    }

    public function createMapWithTiles($mapname, array $tiles) {
        unset($tiles['y/x']); //remove caption;
        $map = new Map();
        
        $map->setName($mapname);
        $id = 0;
        foreach ($tiles as $y => $tiles) {
            foreach ($tiles as $x => $tileName) {
                $id++;
                $tile = $this->tileRepository->findByName($tileName);
                
                $mapTile = new MapTile();
                $mapTile->setId($id)
                        ->setX($x)
                        ->setY($y)
                        ->setTile($tile)
                        ->setMap($map);

                $this->mapTileRepository->add($mapTile);
            }
        }
        $this->mapRepository->add($map);
    }

}
