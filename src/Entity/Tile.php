<?php

namespace OpenTribes\Core\Entity;

/**
 * Tile Entity
 *
 * @author BlackScorp<witalimik@web.de>
 */
class Tile
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var boolean
     */
    private $accessible;

    /**
     * @var integer
     */
    private $tileId;
    private $default = false;
    private $width;
    private $height;

    /**
     * @param integer $tileId
     * @param string $name
     * @param boolean $accessible
     */
    public function __construct($tileId, $name, $accessible)
    {
        $this->name       = $name;
        $this->accessible = (bool)$accessible;
        $this->tileId = (int)$tileId;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return boolean
     */
    public function isAccessible()
    {
        return $this->accessible;
    }

    /**
     * @return integer
     */
    public function getTileId()
    {
        return $this->tileId;
    }

    public function isDefault()
    {
        return $this->default;
    }

    public function setDefault($default)
    {
        $this->default = (bool)$default;
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


}
