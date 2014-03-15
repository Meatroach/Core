<?php

namespace OpenTribes\Core\Entity;

/**
 * Description of City
 *
 * @author BlackScorp<witalimik@web.de>
 */
class City {

    private $id;
    private $name;
    private $owner;
    private $x;
    private $y;

    function __construct($id, $name, User $owner, $x, $y) {
        $this->id    = $id;
        $this->name  = $name;
        $this->owner = $owner;
        $this->x     = $x;
        $this->y     = $y;
    }
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getOwner() {
        return $this->owner;
    }

    public function getX() {
        return $this->x;
    }

    public function getY() {
        return $this->y;
    }


}
