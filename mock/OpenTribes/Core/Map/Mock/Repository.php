<?php

namespace OpenTribes\Core\Map\Mock;
use OpenTribes\Core\Map\Repository as MapRepositoryInterface;
use OpenTribes\Core\Map;
class Repository implements MapRepositoryInterface{
    private $data = array();
    public function add(Map $map) {
        $this->data[$map->getName()] = $map;
    }
    public function findById($id) {
        ;
    }
    public function findByName($name) {
        ;
    }
    
}
