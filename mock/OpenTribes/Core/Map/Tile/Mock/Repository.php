<?php

namespace OpenTribes\Core\Map\Tile\Mock;

use OpenTribes\Core\Map\Tile\Repository as TileRepositoryInterface;
use OpenTribes\Core\Map\Tile as MapTile;

class Repository implements TileRepositoryInterface {

    private $data;

    public function add(MapTile $mapTile) {
        $this->data[$mapTile->getId()] = $mapTile;
    }

    public function findByLocation($x, $y) {
      
        foreach ($this->data as $mapTile) {
            if ($mapTile->getX() == $x && $mapTile->getY() == $y) {
                return $mapTile;
            }
        }
        return null;
    }

}