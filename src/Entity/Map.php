<?php

namespace OpenTribes\Core\Entity;

/**
 * Description of Map
 *
 * @author BlackScorp<witalimik@web.de>
 */
class Map {

    private $id;
    private $name;
    private $tiles = array();

    public function __construct($id, $name, array $tiles) {
        $this->id   = $id;
        $this->name = $name;
        foreach ($tiles as $tile) {
            $this->addTile($tile);
        }
    }

    public function addTile(Tile $tile) {
        $this->tiles[] = $tile;
    }
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getTiles() {
        return $this->tiles;
    }


}
