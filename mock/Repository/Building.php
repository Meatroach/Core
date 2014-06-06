<?php

namespace OpenTribes\Core\Mock\Repository;

use OpenTribes\Core\Entity\Building as BuildingEntity;
use OpenTribes\Core\Repository\Building as BuildingRepository;

/**
 * Description of Building
 *
 * @author Witali
 */
class Building implements BuildingRepository
{

    private $buildings = array();

    /**
     * {@inheritDoc}
     */
    public function add(BuildingEntity $building)
    {
        $this->buildings[$building->getId()] = $building;
    }

    /**
     * {@inheritDoc}
     */
    public function create($id, $name, $minimumLevel, $maximumLevel)
    {
        return new BuildingEntity($id, $name, $minimumLevel, $maximumLevel);
    }

    /**
     * {@inheritDoc}
     */
    public function getUniqueId()
    {
        $countBuilding = count($this->buildings);
        $countBuilding++;
        return $countBuilding;
    }

    /**
     * {@inheritDoc}
     */
    public function findAll()
    {
        return $this->buildings;
    }

    /**
     * {@inheritDoc}
     */
    public function sync()
    {
        ;
    }

}
