<?php

namespace OpenTribes\Core\Entity;


class CityEntity {
    /**
     * @var UserEntity
     */
    private $owner;

    /**
     * @return UserEntity
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param UserEntity $owner
     */
    public function setOwner(UserEntity $owner)
    {
        $this->owner = $owner;
    }


}