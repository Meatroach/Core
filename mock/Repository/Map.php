<?php

namespace OpenTribes\Core\Mock\Repository;

use OpenTribes\Core\Entity\Map as MapEntity;
use OpenTribes\Core\Repository\Map as MapRepository;

/**
 * Description of Map
 *
 * @author BlackScorp<witalimik@web.de>
 */
class Map implements MapRepository {

    /**
     * @var MapEntity
     */
    private $map = null;

    public function add(MapEntity $map) {
        $this->map = $map;
    }

    public function create($id,$name) {
        return new MapEntity($id,$name);
    }

    public function getTile($y, $x) {
        return $this->map->getTile($y, $x);
    }

    /**
     * @param string $y
     * @param string $x
     */
    public function tileIsAccessible($y, $x) {
        $tile = $this->map->getTile($y, $x);
        if (!$tile) {
            return false;
        }
        
        return $tile->isAccessible();
    }
    public function getCenterX() {
        return $this->map->getWidth()/2;
    }
    public function getCenterY() {
        return $this->map->getHeight()/2;
    }
    public function sync() {
        ;
    }
    public function getUniqueId() {
        return 1;
    }
}
