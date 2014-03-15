<?php

namespace OpenTribes\Core\Mock\Repository;

use OpenTribes\Core\Entity\City as CityEntity;
use OpenTribes\Core\Entity\User as UserEntity;
use OpenTribes\Core\Repository\City as CityRepository;

/**
 * Description of City
 *
 * @author BlackScorp<witalimik@web.de>
 */
class City implements CityRepository {

    private $cities = array();

    public function add(CityEntity $city) {
        $this->cities[$city->getId()] = $city;
    }

    public function create($id, $name, UserEntity $owner, $x, $y) {
        return new CityEntity($id, $name, $owner, $x, $y);
    }

    public function getUniqueId() {
        $countCities = count($this->cities);
        $countCities++;
        return $countCities;
    }

}
