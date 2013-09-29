<?php

namespace OpenTribes\Core\City;
use OpenTribes\Core\User;
use OpenTribes\Core\City;
interface Repository{
public function findByName($name);
public function findByUser(User $user);
public function add(City $city);
public function create();
}