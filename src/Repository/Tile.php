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
     * @param integer $tileId
     * @param string $name
     * @param boolean $isAccessible
     * @return TileEntity
     */
    public function create($tileId, $name, $isAccessible);

    /**
     * @param TileEntity $tile
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
     * @param int $tileId
     * @return TileEntity|null
     */
    public function findById($tileId);

    /**
     * @return void
     */
    public function sync();
}
