<?php

namespace OpenTribes\Core\Repository;

use OpenTribes\Core\Entity\Map as MapEntity;

/**
 *
 * @author BlackScorp<witalimik@web.de>
 */
interface Map {
    /**
     * @return MapEntity
     */
    public function create($name);

    public function add(MapEntity $map);
    public function tileIsAccessible($y,$x);
    public function getTile($y,$x);
    public function getCenterX();
    public function getCenterY();
    
}
