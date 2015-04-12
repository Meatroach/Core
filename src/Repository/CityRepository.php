<?php

namespace OpenTribes\Core\Repository;


use OpenTribes\Core\Entity\CityEntity;

interface CityRepository {
    /**
     * @param $username
     * @return CityEntity[]| array
     */
    public function findAllByUsername($username);
    public function add(CityEntity $city);
    public function countUserCities($username);
}