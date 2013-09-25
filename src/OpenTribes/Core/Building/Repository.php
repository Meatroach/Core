<?php

namespace OpenTribes\Core\Building;

use OpenTribes\Core\Building;
interface Repository{
public function add(Building $building);
public function findByName($name);
public function findById($id);
public function findAll();
}
