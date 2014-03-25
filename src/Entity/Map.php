<?php

namespace OpenTribes\Core\Entity;
 
/**
 * Description of Map
 *
 * @author BlackScorp<witalimik@web.de>
 */
class Map {

    private $name;
    private $tiles = array(array());

    public function __construct( $name) {
        $this->name = $name;
    }

    public function addTile(Tile $tile, $y, $x) {
        $this->tiles[(int)$y][(int)$x] = $tile;
    }
    /**
     * 
     * @param type $y
     * @param type $x
     * @return Tile
     */
    public function getTile($y,$x){
        return isset($this->tiles[$y][$x])?$this->tiles[$y][$x]:null;
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
