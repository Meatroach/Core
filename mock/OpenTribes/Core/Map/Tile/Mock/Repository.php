<?php

namespace OpenTribes\Core\Map\Tile\Mock;

use OpenTribes\Core\Map\Tile\Repository as TileRepositoryInterface;
use OpenTribes\Core\Map\Tile as MapTile;

class Repository implements TileRepositoryInterface {

    private $data;

    public function add(MapTile $mapTile) {
        $key = implode('_',array($mapTile->getX(),$mapTile->getY()));
        $this->data[$key] = $mapTile;
    }

    public function findByLocation($x, $y) {
         $key = implode('_',array($x,$y));
      
         return isset($this->data[$key]) ?$this->data[$key] : null;
     
    }

}