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

    public function create($name) {
        return new MapEntity($name);
    }

    public function getTile($y, $x) {
        return $this->map->getTile($y, $x);
    }

    public function tileIsAccessible($y, $x) {
        $tile = $this->map->getTile($y, $x);
        if (!$tile)
            return false;

        return $tile->isAccessible();
    }

}
