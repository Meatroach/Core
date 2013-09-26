<?php

namespace OpenTribes\Core\Resource\Mock;
use OpenTribes\Core\Resource\Repository as ResourceRepoInterface;

use OpenTribes\Core\Resource;
class Repository implements ResourceRepoInterface{
    private $data = array();
    public function add(Resource $resouce) {
        $this->data[$resouce->getName()] = $resouce;
    }
    public function findById($id) {
          foreach($this->data as $resource){
            if($resource->getId() === $id) return $resource;
        }
        return null;
    }
    public function findByName($name) {
            return isset($this->data[$name])? $this->data[$name]:null;
    
    }
}