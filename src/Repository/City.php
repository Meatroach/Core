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
     * @param \OpenTribes\Core\Entity\User $owner
     * @param \interger $y
     * @param \integer $x
     * @return CityEntity
     */
    public function create($id, $name, UserEntity $owner, $y, $x);

    /**
     * Add city entity into repository
     * @param \OpenTribes\Core\Entity\City $city
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
     * @param \interger $x
     * @return \OpenTribes\Core\Entity\City|null
     */
    public function findByLocation($y, $x);
    
    public function replace(CityEntity $city);
    public function findAllByOwner(UserEntity $owner);
    public function countAll();
    public function sync();

    public function delete(CityEntity $city);

    public function flush();
}
