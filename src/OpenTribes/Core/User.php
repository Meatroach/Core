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

use OpenTribes\Core\Message\Repository as MessageRepository;
use OpenTribes\Core\Message;
use OpenTribes\Core\User\Role as UserRole;
use OpenTribes\Core\User\Exception\Username\Short as UserNameTooShortException;
use OpenTribes\Core\User\Exception\Username\Long as UserNameTooLongException;
use OpenTribes\Core\User\Exception\Username\Invalid as UserNameInvalidException;
use OpenTribes\Core\User\Exception\Username\EmptyException as UserNameEmptyException;
use OpenTribes\Core\User\Exception\Password\EmptyException as PasswordEmptyException;
use OpenTribes\Core\User\Exception\Password\Short as PasswordTooShortException;
use OpenTribes\Core\User\Exception\Email\EmptyException as EmailEmptyException;
use OpenTribes\Core\User\Exception\Email\Invalid as EmailInvalidException;

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
     * @var \OpenTribes\Core\Message\Repository $messageRepository 
     */
    protected $messageRepository;

    /**
     * @param \OpenTribes\Core\Message\Repository $messageRepository
     * @return \OpenTribes\Core\User
     */
    public function __construct(MessageRepository $messageRepository) {
        $this->messageRepository = $messageRepository;
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
     * @throws PasswordEmptyException
     * @throws PasswordTooShortException
     */
    public function setPassword($password) {
        if (in_array($password, array(null, false, '', array()), true)) {
            $this->messageRepository->add(new Message('Password is empty'));
            return $this;
        }

        if (strlen($password) < 6) {
            $this->messageRepository->add(new Message('Password is too short'));
            return $this;
        }

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
     * @throws UserNameEmptyException
     * @throws UserNameInvalidException
     * @throws UserNameTooShortException
     * @throws UserNameTooLongException
     */
    public function setUsername($username) {
        if (in_array($username, array(null, false, '', array()), true)) {
            $this->messageRepository->add(new Message('Username is empty'));
            return $this;
        }

        if ((bool) preg_match('/^[-a-z0-9_]++$/iD', $username) === false) {
            $this->messageRepository->add(new Message('Username is invalid'));
            return $this;
        }

        if (strlen($username) < 4) {
            $this->messageRepository->add(new Message('Username is too short'));
            return $this;
        }

        if (strlen($username) > 32) {
            $this->messageRepository->add(new Message('Username is too long'));
            return $this;
        }


        $this->username = $username;
        return $this;
    }

    /**
     * @param String $email
     * @return \OpenTribes\Core\User
     * @throws EmailEmptyException
     * @throws EmailInvalidException
     */
    public function setEmail($email) {
        if (in_array($email, array(null, false, '', array()), true)) {
            $this->messageRepository->add(new Message('E-Mail address is empty'));
            return $this;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->messageRepository->add(new Message('E-Mail address is invalid'));
            return $this;
        }

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
     * @return Array $userRoles
     */
    public function getRoles() {
        return $this->userRole;
    }

    /**
     * Checks if a user has a role with given name
     * @param String $name
     * @return boolean
     */
    public function hasRole($name) {
        foreach ($this->userRole as $userRole) {
            $role = $userRole->getRole();
            if ($role->getName() === $name)
                return true;
        }
    }

    /**
     * @return Integer $id
     */
    public function getId() {
        return $this->id;
    }

}

