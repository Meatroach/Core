<?php

namespace OpenTribes\Core\Repository;

use OpenTribes\Core\Entity\City as CityEntity;

/**
 *
 * @author BlackScorp<witalimik@web.de>
 */
interface CityBuildings
{
    /**
     * @param integer $posY
     * @param integer $posX
     * @return CityEntity|null
     */
    public function findByLocation($posY, $posX);

    /**
     * @param CityEntity $city
     * @return void
     */
    public function replace(CityEntity $city);

    /**
     * @return void
     */
    public function sync();
}
