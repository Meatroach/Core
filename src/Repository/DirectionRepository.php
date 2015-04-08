<?php

namespace OpenTribes\Core\Repository;


use OpenTribes\Core\Entity\DirectionEntity;

interface DirectionRepository {
    /**
     * @return DirectionEntity[]
     */
    public function findAll();
}