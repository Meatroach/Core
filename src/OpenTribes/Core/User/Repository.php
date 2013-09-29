<?php

namespace OpenTribes\Core\User;

use OpenTribes\Core\User;

interface Repository {
 
    public function findByUsername($username);
    public function findByEmail($email);
    public function add(User $user);
    public function create();
}