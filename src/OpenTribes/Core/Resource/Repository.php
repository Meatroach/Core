<?php

namespace OpenTribes\Core\Resource;
use OpenTribes\Core\Resource;

interface Repository{
public function add(Resource $resouce);
public function findByName($name);

}
