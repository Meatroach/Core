<?php

namespace OpenTribes\Core\Repository;

use OpenTribes\Core\Entity\Map as MapEntity;

/**
 *
 * @author BlackScorp<witalimik@web.de>
 */
interface Map {
    /**
     * @param integer $id
     * @return MapEntity
     */
    public function create($id,$name);

    /**
     * @return integer
     */
    public function getUniqueId();

    /**
     * @return void
     */
    public function add(MapEntity $map);

    /**
     * @return void
     */
    public function sync();
    
}
