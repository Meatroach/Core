<?php

namespace OpenTribes\Core\Building\BuildTime\Mock;

use OpenTribes\Core\Building\BuildTime\Repository as RepositoryInterface;
use OpenTribes\Core\Building\BuildTime;
class Repository implements RepositoryInterface{
    private $data;
    public function add(BuildTime $buildTime) {
        $this->data[]= $buildTime;
    }
    public function findAll() {
        ;
    }
    public function findByName($name) {
        ;
    }
}