<?php

namespace OpenTribes\Core\Mock\Repository;

use OpenTribes\Core\Entity\Map as MapEntity;
use OpenTribes\Core\Repository\Map as MapRepository;

/**
 * Description of Map
 *
 * @author BlackScorp<witalimik@web.de>
 */
class Map implements MapRepository
{

    /**
     * @var MapEntity[]
     */
    private $maps = null;

    /**
     * {@inheritDoc}
     */
    public function add(MapEntity $map)
    {
        $this->maps[$map->getMapId()] = $map;
    }

    /**
     * {@inheritDoc}
     */
    public function create($mapId, $name)
    {
        return new MapEntity($mapId, $name);
    }


    /**
     * {@inheritDoc}
     */
    public function sync()
    {
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function getUniqueId()
    {
        $count = count($this->maps);
        $count++;
        return $count;
    }

    /**
     * {@inheritDoc}
     */
    public function findOneByName($name)
    {

        foreach ($this->maps as $map) {
            if ($map->getName() === $name) {
                return $map;
            }
        }
    }

    public function delete(MapEntity $map)
    {
        if (isset($this->maps[$map->getMapId()])) {
            unset($this->maps[$map->getMapId()]);
        }
    }

    public function replace(MapEntity $map)
    {
        $this->maps[$map->getMapId()] = $map;
    }

}
