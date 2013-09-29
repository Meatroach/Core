<?php

namespace OpenTribes\Core\Map;

use OpenTribes\Core\Map;

interface Repository {


    public function findByName($name);

    public function add(Map $map);
}