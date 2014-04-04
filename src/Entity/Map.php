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
    private $id;
    /**
     * @var Tile[]
     */
    private $tiles = array(array());
    private $width   = 0;
    private $height  = 0;

    /**
     * @param \integer $id
     * @param \string $name
     */
    public function __construct($id, $name) {
        $this->id   = $id;
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
     * @return \string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return Tile[]
     */
    public function getTiles() {
        return $this->tiles;
    }
    public function getWidth() {
        return $this->width;
    }

    public function getHeight() {
        return $this->height;
    }

    public function setWidth($width) {
        $this->width = (int) $width;
    }

    public function setHeight($height) {
        $this->height = (int) $height;
    }

    public function getCenterX() {
        return ~~($this->getWidth() / 2);
    }

    public function getCenterY() {
        return ~~($this->getHeight() / 2);
    }
    public function isValidLocation($y, $x) {
        return $x > 0 && $y > 0 && $x <= $this->getWidth() && $y <= $this->getHeight();
    }

    /**
     * @param string $y
     * @param string $x
     */
    public function isAccessible($y, $x) {
        if ($this->getTile($y, $x)) {
            return $this->getTile($y, $x)->isAccessible();
        }
        return true;
    }
    public function getId() {
        return $this->id;
    }


}
