<?php

namespace OpenTribes\Core\Repository;

use OpenTribes\Core\Entity\City as CityEntity;
use OpenTribes\Core\Entity\User as UserEntity;

/**
 * City Repository 
 * @author BlackScorp<witalimik@web.de>
 */
interface City {

    /**
     * get unique ID to create new entity
     * @return \integer
     */
    public function getUniqueId();

    /**
     * Create new city entity
     * @param \integer $id
     * @param \string $name
     * @param UserEntity $owner
     * @param \interger $y
     * @param \integer $x
     * @return CityEntity
     */
    public function create($id, $name, UserEntity $owner, $y, $x);

    /**
     * Add city entity into repository
     * @param CityEntity $city
     * @return void
     */
    public function add(CityEntity $city);

    /**
     * check if city exists at location
     * @param \integer $y
     * @param \interger $x
     * @return \boolean
     */
    public function cityExistsAt($y, $x);

    /**
     * find city entity by given location
     * @param \integer $y
     * @param \integer $x
     * @return CityEntity|null
     */
    public function findByLocation($y, $x);
    
    /**
     * @return void
     */
    public function replace(CityEntity $city);
    /**
     * @param UserEntity $owner City Owner
     * @return CityEntity[]
     */
    public function findAllByOwner(UserEntity $owner);

    /**
     * @return \integer
     */
    public function countAll();

    /**
     * @return void
     */
    public function sync();

    /**
     * @return void
     */
    public function delete(CityEntity $city);

    /**
     * @return null|\integer
     */
    public function flush();
}
