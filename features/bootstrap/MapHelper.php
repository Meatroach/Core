<?php

use OpenTribes\Core\Repository\Map as MapRepository;
use OpenTribes\Core\Repository\Tile as TileRepository;

class MapHelper {

    private $mapRepository;
    private $tileRepository;

    function __construct(MapRepository $mapRepository, TileRepository $tileRepository) {
        $this->mapRepository  = $mapRepository;
        $this->tileRepository = $tileRepository;
    }

    public function createMap($mapName, array $grid) {

        $map   = $this->mapRepository->create( $mapName);
       
        foreach($grid as $y => $positions){
            foreach ($positions as $x => $tileName){
                $tile = $this->tileRepository->findByName($tileName);
                $map->addTile($tile, $y, $x);
            }
        }
          $this->mapRepository->add($map);
        
      
    }

}
