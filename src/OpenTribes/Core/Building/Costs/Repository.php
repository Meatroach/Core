<?php

namespace OpenTribes\Core\Building\Costs;
use OpenTribes\Core\Building\Costs;
interface Repository{

public function findAll();
public function add(Costs $costs);
}