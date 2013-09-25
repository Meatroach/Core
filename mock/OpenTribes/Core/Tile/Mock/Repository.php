<?php
namespace OpenTribes\Core\Tile\Mock;

use OpenTribes\Core\Tile\Repository as RepositoryInterface;
use OpenTribes\Core\Tile;
class Repository implements RepositoryInterface{
    protected $data = array();

    public function findById($id){
        
    }
    public function findByName($name){
        return isset($this->data[$name])? $this->data[$name]:null;
   
    }
    public function add(Tile $tile) {
        $this->data[$tile->getName()] = $tile;
    }
    public function create() {
        return new Tile();
    }
}