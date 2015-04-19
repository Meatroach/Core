<?php

namespace OpenTribes\Core\Silex\Repository;


use OpenTribes\Core\Entity\DirectionEntity;
use OpenTribes\Core\Repository\DirectionRepository;

class ConfigDirectionsRepository implements DirectionRepository
{
    private $directions = [];
    public function __construct(array $directions){
        foreach($directions as $key => $direction){
            $name = $direction['name'];
            $minDegree = $direction['degree']['min'];
            $maxDegree = $direction['degree']['max'];
            $this->directions[]= new DirectionEntity($key,$name,$minDegree,$maxDegree);
        }
    }
    /**
     * @return DirectionEntity[]
     */
    public function findAll()
    {
        return $this->directions;
    }

}