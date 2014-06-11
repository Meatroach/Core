<?php

namespace OpenTribes\Core\Repository;

use OpenTribes\Core\Entity\Tile as TileEntity;

/**
 *
 * @author BlackScorp<witalimik@web.de>
 */
interface Tile
{

    /**
     * @param integer $id
     * @param string $name
     * @param boolean $isAccessible
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
     * @param string $name
     * @return TileEntity|null
     */
    public function findByName($name);

    /**
     * @return TileEntity|null
     */
    public function findById($id);

    /**
     * @return void
     */
    public function sync();


}
