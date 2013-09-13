<?php
namespace OpenTribes\Core\Tile\Mock;

use OpenTribes\Core\Tile\Repository as RepositoryInterface;
use OpenTribes\Core\Tile;
class Repository implements RepositoryInterface{
    protected $data = array();

    public function findById($id){
          if(isset($this->data[$id])) return $this->data[$id];
          return null;
    }
    public function findByName($name){
          foreach ($this->data as $tile) {
            if ($tile->getName() == $name) {
                return $tile;
            }
        }
    }
    public function add(Tile $tile) {
        $this->data[$tile->getId()] = $tile;
    }
    public function create() {
        return new Tile();
    }
}