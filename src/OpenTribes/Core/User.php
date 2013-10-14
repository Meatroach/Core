<?php

/**
 * This file is part of the "Open Tribes" Core Module.
 *
 * @package    OpenTribes\Core
 * @author     Witali Mik <mik@blackscorp.de>
 * @copyright  (c) 2013 BlackScorp Games
 * @license    For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace OpenTribes\Core;

use OpenTribes\Core\User\Role as UserRole;

/**
 * User Entity class
 */
class User extends Entity {

    /**
     * @var Integer $id 
     */
    protected $id;

    /**
     * @var String $username 
     */
    protected $username;

    /**
     * @var String $password 
     */
    protected $password;

    /**
     * @var String $passwordHash 
     */
    protected $passwordHash;

    /**
     * @var String $email 
     */
    protected $email;

    /**
     * @var \DateTime $lastAction 
     */
    protected $lastAction;

    /**
     * @var String $activationCode 
     */
    protected $activationCode;

    /**
     * @var Array $userRole 
     */
    protected $userRole = array();

    /**
     * @param Integer $id
     * @param String $username
     * @param String $passwordHash
     * @param String $email
     * @return \OpenTribes\Core\User
     */
    public function __construct($id, $username, $passwordHash, $email) {
        $this
                ->setId($id)
                ->setUsername($username)
                ->setPasswordHash($passwordHash)
                ->setEmail($email);
        return $this;
    }

    /**
     * @param String $code
     * @return \OpenTribes\Core\User
     */
    public function setActivationCode($code) {
        $this->activationCode = $code;
        return $this;
    }

    /**
     * @param \DateTime $lastAction
     * @return \OpenTribes\Core\User
     */
    public function setLastAction(\DateTime $lastAction) {
        $this->lastAction = $lastAction;
        return $this;
    }

    /**
     * @param String $password
     * @return \OpenTribes\Core\User
     */
    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }

    /**
     * @param String $hash
     * @return \OpenTribes\Core\User
     */
    public function setPasswordHash($hash) {
        $this->passwordHash = $hash;
        return $this;
    }

    /**
     * @param String $username
     * @return \OpenTribes\Core\User
     */
    public function setUsername($username) {
        $this->username = $username;
        return $this;
    }

    /**
     * @param String $email
     * @return \OpenTribes\Core\User
     */
    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    /**
     * @param \OpenTribes\Core\User\Role $userRole
     * @return \OpenTribes\Core\User
     */
    public function addRole(UserRole $userRole) {
        $this->userRole[] = $userRole;
        return $this;
    }

    /**
     * @param Integer $id
     * @return \OpenTribes\Core\User
     */
    public function setId($id) {
        $this->id = (int) $id;
        return $this;
    }

    /**
     * @return \String $username
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @return \String $password
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @return \String $email
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @return \String $activationCode
     */
    public function getActivationCode() {
        return $this->activationCode;
    }

    /**
     * @return \String passwordHash
     */
    public function getPasswordHash() {
        return $this->passwordHash;
    }

    /**
     * @return \DateTime $lastAction
     */
    public function getLastAction() {
        return $this->lastAction;
    }

    /**
     * @return \Array $userRoles
     */
    public function getRoles() {
        return $this->userRole;
    }

    /**
     * Checks if a user has a role with given name
     * @param String $name
     * @return \Boolean
     */
    public function hasRole($name) {
        foreach ($this->userRole as $userRole) {
            $role = $userRole->getRole();
            if ($role->getName() === $name)
                return true;
        }
    }

    /**
     * @return \Integer $id
     */
    public function getId() {
        return $this->id;
    }

}

