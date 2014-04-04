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

    /**
     * {@inheritDoc}
     */
    public function add(MapEntity $map) {
        $this->map = $map;
    }

    /**
     * {@inheritDoc}
     */
    public function create($id, $name) {
        return new MapEntity($id, $name);
    }

    /**
     * {@inheritDoc}
     */
    public function getTile($y, $x) {
        return $this->map->getTile($y, $x);
    }


    /**
     * {@inheritDoc}
     */
    public function sync() {
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function getUniqueId() {
        return 1;
    }

}
