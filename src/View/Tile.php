<?php

namespace OpenTribes\Core\View;

use OpenTribes\Core\Entity\Tile as TileEntity;

/**
 * Description of Tile
 *
 * @author BlackScorp<witalimik@web.de>
 */
class Tile
{
    public $width;
    public $height;
    public $name;
    public $top;
    public $left;
    public $posX;
    public $posY;
    public $layerZ;

    public function __construct(TileEntity $tileEntity)
    {
        $this->width = $tileEntity->getWidth();
        $this->height = $tileEntity->getHeight();
        $this->name = $tileEntity->getName();

    }
}
