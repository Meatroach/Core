<?php

namespace OpenTribes\Core\Repository;

use OpenTribes\Core\Entity\City as CityEntity;
use OpenTribes\Core\Entity\User as UserEntity;

/**
 *
 * @author BlackScorp<witalimik@web.de>
 */
interface City {

    public function getUniqueId();

    public function create($id, $name, UserEntity $owner, $y, $x);

    public function add(CityEntity $city);
    public function cityExistsAt($y,$x);
    public function findByLocation($y,$x);
}
