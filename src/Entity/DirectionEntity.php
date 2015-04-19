<?php

namespace OpenTribes\Core\Entity;


class DirectionEntity {
    private $name = '';
    private $key = '';
    private $minDegree = 0.0;
    private $maxDegree = 0.0;

    public function __construct($key, $name, $minDegree, $maxDegree)
    {
        $this->key = $key;
        $this->name = $name;
        $this->minDegree = $minDegree;
        $this->maxDegree = $maxDegree;
    }


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

}