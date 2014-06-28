<?php

namespace OpenTribes\Core\Entity;

/**
 * Map Entity
 *
 * @author BlackScorp<witalimik@web.de>
 */
class Map
{

    /**
     * @var string
     */
    private $name;
    /**
     * @var integer
     */
    private $mapId;
    /**
     * @var Tile[][]
     */
    private $tiles = array(array());
    private $width = 0;
    private $height = 0;

    /**
     * @param integer $mapId
     * @param string $name
     */
    public function __construct($mapId, $name)
    {
        $this->mapId = $mapId;
        $this->name = $name;
    }

    /**
     * @param Tile $tile
     * @param integer $posY
     * @param integer $posX
     */
    public function addTile(Tile $tile, $posY, $posX)
    {
        $posY = (int)$posY;
        $posX = (int)$posX;
        $this->tiles[$posY][$posX] = $tile;
    }

    /**
     * @param integer $posY
     * @param integer $posX
     * @return Tile
     */
    public function getTile($posY, $posX)
    {
        $posY = (int)$posY;
        $posX = (int)$posX;
        return isset($this->tiles[$posY][$posX]) ? $this->tiles[$posY][$posX] : null;
    }


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Tile[][]
     */
    public function getTiles()
    {
        return $this->tiles;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function setWidth($width)
    {
        $this->width = (int)$width;
    }

    public function setHeight($height)
    {
        $this->height = (int)$height;
    }

    public function getCenterX()
    {
        return ~~($this->getWidth() / 2);
    }

    public function getCenterY()
    {
        return ~~($this->getHeight() / 2);
    }

    /**
     * @param integer $posY
     * @param integer $posX
     * @return bool
     */
    public function isValidLocation($posY, $posX)
    {
        return $posX > 0 && $posY > 0 && $posX <= $this->getWidth() && $posY <= $this->getHeight();
    }

    /**
     * @param integer $posY
     * @param integer $posX
     * @return boolean
     */
    public function isAccessible($posY, $posX)
    {
        if ($this->getTile($posY, $posX)) {
            return $this->getTile($posY, $posX)->isAccessible();
        }
        return true;
    }

    public function getMapId()
    {
        return $this->mapId;
    }
}
