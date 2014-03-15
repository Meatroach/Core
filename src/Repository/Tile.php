<?php

namespace OpenTribes\Core\Repository;

use OpenTribes\Core\Entity\Tile as TileEntity;

/**
 *
 * @author BlackScorp<witalimik@web.de>
 */
interface Tile {

    public function create($id, $name, $isAccessible);

    public function add(TileEntity $tile);
    public function getUniqueId();
    public function findByName($name);
}
