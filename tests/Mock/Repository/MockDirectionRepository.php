<?php

namespace OpenTribes\Core\Test\Mock\Repository;


use OpenTribes\Core\Repository\DirectionRepository;

class MockDirectionRepository implements DirectionRepository{
    private $directions = [];

    public function __construct(array $directions = [])
    {
        $this->directions = $directions;
    }

    public function findAll()
    {
        return $this->directions;
    }

}