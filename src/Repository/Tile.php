<?php

namespace OpenTribes\Core\Repository;

use OpenTribes\Core\Entity\Tile as TileEntity;

/**
 *
 * @author BlackScorp<witalimik@web.de>
 */
interface Tile {

    /**
     * @return TileEntity
     */
    public function create($id, $name, $isAccessible);

    /**
     * @return void
     */
    public function add(TileEntity $tile);

    /**
     * @return integer
     */
    public function getUniqueId();

    /**
     * @return TileEntity|null
     */
    public function findByName($name);

    /**
     * @return void
     */
    public function sync();
}
