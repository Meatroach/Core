<?php


namespace OpenTribes\Core\Repository;
use OpenTribes\Core\Entity\Building as BuildingEntity;
/**
 * Building Repository
 * @author Witali
 */
interface Building {

    /**
     * Create new building entity
     * @param integer $id
     * @param string $name
     * @param integer $minimumLevel
     * @param integer $maximumLevel
     * @return BuildingEntity
     */
    public function create($id, $name, $minimumLevel, $maximumLevel);

    /**
     * Add building entity into repository
     * @param BuildingEntity $building
     * @return void
     */
    public function add(BuildingEntity $building);

    /**
     * get unique ID to create new entity
     * @return integer
     */
    public function getUniqueId();
    /**
     * @return BuildingEntity[]
     */
    public function findAll();

    /**
     * @return void
     */
    public function sync();
}
