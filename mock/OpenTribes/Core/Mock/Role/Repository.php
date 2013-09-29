<?php
namespace OpenTribes\Core\Mock\Role;
use OpenTribes\Core\Role\Repository as RoleRepositoryInterface;
use OpenTribes\Core\Role;
class Repository implements RoleRepositoryInterface{
    private $roles = array();
    public function add(Role $role) {
        $this->roles[$role->getName()]=$role;
    }
    public function findByName($name) {
        return isset($this->roles[$name])?$this->roles[$name]:null;
    }
}