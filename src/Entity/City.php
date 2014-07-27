<?php

namespace OpenTribes\Core\Entity;

/**
 * City Entity
 *
 * @author BlackScorp<witalimik@web.de>
 */
class City
{

    /**
     * @var integer
     */
    private $cityId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var User
     */
    private $owner;

    /**
     * @var integer
     */
    private $posX;

    /**
     * @var integer
     */
    private $posY;

    /**
     * @var boolean
     */
    private $isSelected = false;

    /**
     * @var Building[]
     */
    private $buildings = array();

    /**
     * @param integer $cityId
     * @param string $name
     * @param integer $posY
     * @param integer $posX
     */
    public function __construct($cityId, $name, $posY, $posX)
    {
        $this->cityId = (int)$cityId;
        $this->name = $name;
        $this->posX = (int)$posX;
        $this->posY = (int)$posY;
    }

    /**
     * @param \OpenTribes\Core\Entity\User $owner
     */
    public function setOwner(User $owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return integer
     */
    public function getCityId()
    {
        return $this->cityId;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @return integer
     */
    public function getPosX()
    {
        return $this->posX;
    }

    /**
     * @return integer
     */
    public function getPosY()
    {
        return $this->posY;
    }

    public function addBuilding(Building $building)
    {
        $this->buildings[] = $building;
    }

    public function hasBuildings()
    {
        return count($this->buildings) > 0;
    }

    public function getBuildings()
    {
        return $this->buildings;
    }

    public function isSelected()
    {
        return $this->isSelected;
    }

    public function setSelected($selected)
    {
        $this->isSelected = (bool)$selected;
    }
}
