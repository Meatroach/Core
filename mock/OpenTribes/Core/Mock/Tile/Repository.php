<?php

namespace OpenTribes\Core\Mock\Tile;
use OpenTribes\Core\Tile\Repository as TileRepositoryInterface;
use OpenTribes\Core\Tile;
class Repository implements TileRepositoryInterface{
    private $tiles = array();
    public function add(Tile $tile) {
        $this->tiles[$tile->getName()] = $tile;
    }
    public function findByName($name) {
        return isset($this->tiles[$name])?$this->tiles[$name]:null;
    }
}
