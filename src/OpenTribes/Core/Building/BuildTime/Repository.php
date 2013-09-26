<?php

namespace OpenTribes\Core\Building\BuildTime;
use OpenTribes\Core\Building\BuildTime;
interface Repository{
public function findByName($name);
public function findAll();

public function add(BuildTime $buildTime);
}