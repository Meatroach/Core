<?php

namespace OpenTribes\Core\Repository;

use OpenTribes\Core\Entity\Map as MapEntity;

/**
 *
 * @author BlackScorp<witalimik@web.de>
 */
interface Map
{

    /**
     * @param integer $mapMapId
     * @param string $name
     * @return MapEntity
     */
    public function create($mapMapId, $name);

    /**
     * @return integer
     */
    public function getUniqueId();

    /**
     * @param MapEntity $map
     * @return void
     */
    public function add(MapEntity $map);

    /**
     * @param MapEntity $map
     * @return void
     */
    public function replace(MapEntity $map);

    /**
     * @param MapEntity $map
     * @return void
     */
    public function delete(MapEntity $map);

    /**
     * @return void
     */
    public function sync();


    /**
     * @param string $name
     * @return MapEntity
     */
    public function findOneByName($name);
}
