<?php

namespace OpenTribes\Core\Repository;

use OpenTribes\Core\Entity\City as CityEntity;

/**
 *
 * @author BlackScorp<witalimik@web.de>
 */
interface CityBuildings {
    /**
     * @return CityEntity|null
     */
    public function findByLocation($y, $x);

    public function replace(CityEntity $city);
    public function sync();
}
