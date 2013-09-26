<?php

namespace OpenTribes\Core\Building\Costs\Mock;
use OpenTribes\Core\Building\Costs\Repository as CostsRepository;
use \OpenTribes\Core\Building\Costs;
class Repository implements CostsRepository{
    private $data;
    public function add(Costs $costs) {
        $this->data[]=$costs;
    }
    public function findByName($name) {
        ;
    }
    public function findAll() {
        return $this->data;
    }
}