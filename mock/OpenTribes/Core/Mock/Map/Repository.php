<?php
namespace OpenTribes\Core\Mock\Map;
use OpenTribes\Core\Map\Repository as MapRepositoryInterface;
use OpenTribes\Core\Map;
class Repository implements MapRepositoryInterface{
    private $maps = array();
    public function add(Map $map) {
    $this->maps[$map->getName()] = $map;
    }

    public function findByName($name) {
        return isset($this->maps[$name]) ? $this->maps[$name]:null;
    }
}