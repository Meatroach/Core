<?php
namespace OpenTribes\Core\Mock\Resource;
use OpenTribes\Core\Resource\Repository as ResourceRepositoryInterface;
use OpenTribes\Core\Resource;
class Repository implements ResourceRepositoryInterface{
    private $resources = array();
    public function add(Resource $resouce) {
        $this->resources[$resouce->getName()] = $resouce;
    }
 
    public function findByName($name) {
        return isset($this->resources[$name])? $this->resources[$name]:null;
    }
}