<?php
//Entities
use OpenTribes\Core\Tile;
use OpenTribes\Core\Map;
use OpenTribes\Core\Map\Tile as MapTile;

//Repositories
use OpenTribes\Core\Mock\Tile\Repository as TileRepository;
use OpenTribes\Core\Mock\Map\Repository as MapRepository;
use OpenTribes\Core\Mock\Map\Tile\Repository as MapTileRepository;

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
            $tile['accessable'] = $statsMapper[$tile['accessable']];
            foreach($tile as $field => $value){
                $tileEntity->{$field} = $value;
            }
            $this->tileRepository->add($tileEntity);
        }
    
    }

    public function createMapWithTiles($mapname, array $tiles) {
        unset($tiles['y/x']); //remove caption;
        $map = new Map();
        
        $map->setName($mapname);
        
        foreach ($tiles as $y => $tiles) {
            foreach ($tiles as $x => $tileName) {
            
                $tile = $this->tileRepository->findByName($tileName);
                
                $mapTile = new MapTile();
                $mapTile
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
