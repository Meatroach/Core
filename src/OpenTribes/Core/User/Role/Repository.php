<?php
namespace OpenTribes\Core\User\Role;
use OpenTribes\Core\User\Role as UserRole;
interface Repository{
    public function add(UserRole $playerRoles);
  
}