<?php

namespace OpenTribes\Core\User;

use OpenTribes\Core\Entity;
use OpenTribes\Core\Role;
use OpenTribes\Core\User;

class Role extends Entity{
    protected $role;
    protected $user;
    public function setUser(User $user){
        $this->user = $user;
        return $this;
    }

    public function setRole(Role $role){
        $this->roles = $role;
        return $this;
    }

    public function getRole(){
        return $this->roles;
    }
    public function getUser(){
        return $this->user;
    }

}