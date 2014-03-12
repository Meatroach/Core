<?php

namespace OpenTribes\Core\Repository;

use OpenTribes\Core\Entity\Map as MapEntity;

/**
 *
 * @author BlackScorp<witalimik@web.de>
 */
interface Map {

    public function create($id, $name);

    public function add(MapEntity $map);
}
