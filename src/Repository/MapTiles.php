<?php

namespace OpenTribes\Core\Repository;

use OpenTribes\Core\Entity\Map as MapEntity;

/**
 *
 * @author Witali
 */
interface MapTiles
{

    /**
     * @return MapEntity
     */
    public function getMap();

    /**
     * @param MapEntity $map
     * @return void
     */
    public function add(MapEntity $map);

    /**
     * @return \OpenTribes\Core\Entity\Tile
     */
    public function getDefaultTile();

    /**
     * @param array $area
     * @return MapEntity
     */
    public function findAllInArea(array $area);
}
