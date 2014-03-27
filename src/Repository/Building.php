<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace OpenTribes\Core\Repository;
use OpenTribes\Core\Entity\Building as BuildingEntity;
/**
 *
 * @author Witali
 */
interface Building {
public function create($id,$name,$minimumLevel,$maximumLevel);
public function add(BuildingEntity $building);
public function getUniqueId();
}
