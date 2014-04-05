<?php

namespace OpenTribes\Core\Repository;

use OpenTribes\Core\Entity\City as CityEntity;

/**
 *
 * @author BlackScorp<witalimik@web.de>
 */
interface CityBuildings {
    /**
     * @param integer|string $y
     * @param integer|string $x
     * @return CityEntity|null
     */
    public function findByLocation($y, $x);

    /**
     * @return void
     */
    public function replace(CityEntity $city);

    /**
     * @return void
     */
    public function sync();
}
