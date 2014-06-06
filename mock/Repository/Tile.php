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
        $this->tiles[$tile->getId()] = $tile;
    }

    /**
     * {@inheritDoc}
     */
    public function create($id, $name, $isAccessible)
    {
        return new TileEntity($id, $name, $isAccessible);
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

    public function findById($id)
    {
        foreach ($this->tiles as $tile) {
            if ($tile->getId() === $id) {
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
