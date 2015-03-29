<?php

namespace OpenTribes\Core\Repository;


use OpenTribes\Core\Entity\CityEntity;

interface UserCityRepository {
    /**
     * @param $username
     * @return CityEntity[]| null
     */
    public function findAllByUsername($username);
    public function add(CityEntity $city);
}