<?php
namespace OpenTribes\Core\Mock\Map\Tile;
use OpenTribes\Core\Map\Tile\Repository as MapTileRepositoryInterface;
use OpenTribes\Core\Map\Tile as MapTile;
class Repository implements MapTileRepositoryInterface{
    private $mapTiles = array();
    public function add(MapTile $mapTile) {
        $key = $this->getKey($mapTile->getX(),$mapTile->getY());
        $this->mapTiles[$key] = $mapTile;
    }
    public function findByLocation($x, $y) {
        $key = $this->getKey($x, $y);
        return isset($this->mapTiles[$key])?$this->mapTiles[$key]:null;
    }
    private function getKey($x,$y){
        return sprint('%d_%d',$x,$y);
    }
}