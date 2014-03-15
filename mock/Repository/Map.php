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

    private $maps = array();

    public function add(MapEntity $map) {
        $this->maps[$map->getId()] = $map;
    }

    public function create($id, $name) {
        return new MapEntity($id, $name);
    }

    public function getUniqueId() {
        $countMaps = count($this->maps);
        $countMaps++;
        return $countMaps;
    }

}
