<?php
namespace OpenTribes\Core\Mock\User\Role;
use OpenTribes\Core\User\Role\Repository as UserRoleRepositoryInterface;
use OpenTribes\Core\User\Role as UserRole;
class Repository implements UserRoleRepositoryInterface{
    private $userRoles = array();
    public function add(UserRole $userRole) {
        $this->userRoles[]=$userRole;
    }
   
}