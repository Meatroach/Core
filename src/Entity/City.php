<?php

namespace OpenTribes\Core\Entity;

/**
 * City Entity
 *
 * @author BlackScorp<witalimik@web.de>
 */
class City {

    /**
     * @var \integer
     */
    private $id;

    /**
     * @var \string
     */
    private $name;

    /**
     * @var User
     */
    private $owner;

    /**
     * @var \integer
     */
    private $x;

    /**
     * @var \integer
     */
    private $y;
    /**
     * @var Building[]
     */
    private $buildings = array();
    /**
     * @param integer $id
     * @param string $name
     * @param User $owner
     * @param integer $y
     * @param integer $x
     */
    public function __construct($id, $name, User $owner, $y, $x) {
        $this->id    = (int) $id;
        $this->name  = $name;
        $this->owner = $owner;
        $this->x     = (int) $x;
        $this->y     = (int) $y;
    }

    /**
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return User
     */
    public function getOwner() {
        return $this->owner;
    }

    /**
     * @return integer
     */
    public function getX() {
        return $this->x;
    }

    /**
     * @return integer
     */
    public function getY() {
        return $this->y;
    }
    public function addBuilding(Building $building){
        $this->buildings[]=$building;
    }
    
    public function hasBuildings(){
        return count($this->buildings)>0;
    }

    public function getBuildings(){
        return $this->buildings;
    }
}
