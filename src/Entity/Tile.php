<?php

namespace OpenTribes\Core\Entity;

/**
 * Description of Tile
 *
 * @author BlackScorp<witalimik@web.de>
 */
class Tile {

    private $name;
    private $isAccessible;
    private $id;
    private $x;
    private $y;

    function __construct($id, $name, $isAccessible) {
        $this->name         = $name;
        $this->isAccessible = $isAccessible;
        $this->id           = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function getIsAccessible() {
        return $this->isAccessible;
    }

    public function getId() {
        return $this->id;
    }

    public function getX() {
        return $this->x;
    }

    public function getY() {
        return $this->y;
    }

    public function setX($x) {
        $this->x = $x;
    }

    public function setY($y) {
        $this->y = $y;
    }

}
