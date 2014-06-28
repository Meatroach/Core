<?php

namespace OpenTribes\Core\Repository;

use OpenTribes\Core\Entity\City as CityEntity;
use OpenTribes\Core\Entity\User as UserEntity;

/**
 * City Repository
 * @author BlackScorp<witalimik@web.de>
 */
interface City
{

    /**
     * get unique ID to create new entity
     * @return integer
     */
    public function getUniqueId();

    /**
     * Create new city entity
     * @param integer $cityId
     * @param string $name
     * @param integer $posY
     * @param integer $posX
     * @return CityEntity
     */
    public function create($cityId, $name, $posY, $posX);

    /**
     * Add city entity into repository
     * @param CityEntity $city
     * @return void
     */
    public function add(CityEntity $city);

    /**
     * check if city exists at location
     * @param integer $posY
     * @param integer $posX
     * @return boolean
     */
    public function cityExistsAt($posY, $posX);

    /**
     * find city entity by given location
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
     * @param UserEntity $owner City Owner
     * @return CityEntity[]
     */
    public function findAllByOwner(UserEntity $owner);

    /**
     * @return integer
     */
    public function countAll();

    /**
     * @return void
     */
    public function sync();

    /**
     * @param CityEntity $city
     * @return void
     */
    public function delete(CityEntity $city);

    /**
     * @return null|integer
     */
    public function flush();

    /**
     * @param string $username
     * @return CityEntity
     */
    public function findSelectedByUsername($username);

    /**
     * @param array $area
     * @return CityEntity[]
     */
    public function findAllInArea(array $area);

    public function getLastCreatedCity();
}
