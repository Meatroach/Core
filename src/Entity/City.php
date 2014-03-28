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
     * @param \integer $id
     * @param \string $name
     * @param \OpenTribes\Core\Entity\User $owner
     * @param \integer $y
     * @param \integer $x
     */
    function __construct($id, $name, User $owner, $y, $x) {
        $this->id    = (int) $id;
        $this->name  = $name;
        $this->owner = $owner;
        $this->x     = (int) $x;
        $this->y     = (int) $y;
    }

    /**
     * @return \integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return \string
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
     * @return \integer
     */
    public function getX() {
        return $this->x;
    }

    /**
     * @return \integer
     */
    public function getY() {
        return $this->y;
    }

}
