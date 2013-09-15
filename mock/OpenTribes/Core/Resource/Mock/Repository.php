<?php

namespace OpenTribes\Core\Resource\Mock;
use OpenTribes\Core\Resource\Repository as ResourceRepoInterface;

use OpenTribes\Core\Resource;
class Repository implements ResourceRepoInterface{
    private $data = array();
    public function add(Resource $resouce) {
        $this->data[$resouce->getId()] = $resouce;
    }
    public function findById($id) {
       return isset($this->data[$id])? $this->data[$id]:null;
    }
    public function findByName($name) {
        foreach($this->data as $resource){
            if($resource->getName() === $name) return $resource;
        }
        return null;
    }
}