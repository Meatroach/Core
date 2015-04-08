<?php

namespace OpenTribes\Core\Entity;


class DirectionEntity {
    private $name = '';

    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

}