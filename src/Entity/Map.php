<?php

namespace OpenTribes\Core\Entity;

/**
 * Map Entity
 *
 * @author BlackScorp<witalimik@web.de>
 */
class Map {

    /**
     * @var \string
     */
    private $name;

    /**
     * @var Tile[]
     */
    private $tiles = array(array());

    /**
     * @param \string $name
     */
    public function __construct($name) {
        $this->name = $name;
    }

    /**
     * @param \OpenTribes\Core\Entity\Tile $tile
     * @param \integer $y
     * @param \integer $x
     */
    public function addTile(Tile $tile, $y, $x) {
        $y = (int) $y;
        $x = (int) $x;
        $this->tiles[$y][$x] = $tile;
    }

    /**
     * @param \integer $y
     * @param \integer $x
     * @return Tile
     */
    public function getTile($y, $x) {
        $y = (int) $y;
        $x = (int) $x;
        return isset($this->tiles[$y][$x]) ? $this->tiles[$y][$x] : null;
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
     * @return Tiles[]
     */
    public function getTiles() {
        return $this->tiles;
    }

}
