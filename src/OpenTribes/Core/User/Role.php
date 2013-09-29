<?php
/**
 * This file is part of the "Open Tribes" Core Module.
 *
 * @package    OpenTribes\Core
 * @author     Witali Mik <mik@blackscorp.de>
 * @copyright  (c) 2013 BlackScorp Games
 * @license    For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */
namespace OpenTribes\Core\User;

use OpenTribes\Core\Entity;
use OpenTribes\Core\Role as BaseRole;
use OpenTribes\Core\User;
/**
 * User Role relationship Entity
 */
class Role extends Entity{
    /**
     * @var \OpenTribes\Core\Role $role
     */
    protected $role;
    /**
     * @var \OpenTribes\Core\User $user 
     */
    protected $user;
    /**
     * @param \OpenTribes\Core\User $user
     * @return \OpenTribes\Core\User\Role
     */
    public function setUser(User $user){
        $this->user = $user;
        return $this;
    }
    /**
     * @param \OpenTribes\Core\Role $role
     * @return \OpenTribes\Core\User\Role
     */
    public function setRole(BaseRole $role){
        $this->role = $role;
        return $this;
    }
    /**
     * @return \OpenTribes\Core\Role $role
     */
    public function getRole(){
        return $this->role;
    }
    /**
     * @return \OpenTribes\Core\User $role
     */
    public function getUser(){
        return $this->user;
    }

}