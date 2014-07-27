<?php

namespace OpenTribes\Core\Mock\Repository;

use OpenTribes\Core\Entity\Tile as TileEntity;
use OpenTribes\Core\Repository\Tile as TileRepository;

/**
 * Description of Tile
 *
 * @author BlackScorp<witalimik@web.de>
 */
class Tile implements TileRepository
{

    /**
     * @var TileEntity[]
     */
    private $tiles;

    /**
     * {@inheritDoc}
     */
    public function add(TileEntity $tile)
    {
        $this->tiles[$tile->getTileId()] = $tile;
    }

    /**
     * {@inheritDoc}
     */
    public function create($tileId, $name, $isAccessible)
    {
        return new TileEntity($tileId, $name, $isAccessible);
    }

    /**
     * {@inheritDoc}
     */
    public function getUniqueId()
    {
        $countTiles = count($this->tiles);
        $countTiles++;
        return $countTiles;
    }

    /**
     * {@inheritDoc}
     */
    public function findByName($name)
    {
        foreach ($this->tiles as $tile) {
            if ($tile->getName() === $name) {
                return $tile;
            }
        }
        return null;
    }

    public function findById($tileId)
    {
        foreach ($this->tiles as $tile) {
            if ($tile->getTileId() === $tileId) {
                return $tile;
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function sync()
    {
        ;
    }

}
