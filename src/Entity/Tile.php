<?php

namespace OpenTribes\Core\Entity;

/**
 * Description of Tile
 *
 * @author BlackScorp<witalimik@web.de>
 */
class Tile {

    private $name;
    private $accessible;
    private $id;


    function __construct($id, $name, $accessible) {
        $this->name         = $name;
        $this->accessible = $accessible;
        $this->id           = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function isAccessible() {
        return $this->accessible;
    }

    public function getId() {
        return $this->id;
    }

  

}
