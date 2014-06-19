<?php

namespace OpenTribes\Core\Mock\Repository;

use OpenTribes\Core\Entity\User as UserEntity;
use OpenTribes\Core\Repository\User as UserRepository;

/**
 * Description of User
 *
 * @author BlackScorp<witalimik@web.de>
 */
class User implements UserRepository
{

    /**
     * @var UserEntity[]
     */
    private $users = array();
    private $added = array();
    private $modified = array();
    private $deleted = array();

    /**
     * {@inheritDoc}
     */
    public function add(UserEntity $user)
    {
        $this->users[$user->getUserId()] = $user;
        $this->added[$user->getUserId()] = $user->getUserId();
    }

    /**
     * {@inheritDoc}
     */
    public function create($userId, $username, $password, $email)
    {
        return new UserEntity($userId, $username, $password, $email);
    }

    /**
     * {@inheritDoc}
     */
    public function delete(UserEntity $user)
    {
        unset($this->users[$user->getUserId()]);
        $this->deleted[$user->getUserId()] = $user->getUserId();
    }

    /**
     * {@inheritDoc}
     */
    public function getUniqueId()
    {
        $amountOfUsers = count($this->users);
        return ++$amountOfUsers;
    }

    /**
     * {@inheritDoc}
     */
    public function replace(UserEntity $user)
    {
        $this->users[$user->getUserId()] = $user;
        $this->modified[$user->getUserId()] = $user->getUserId();
    }

    /**
     * {@inheritDoc}
     */
    public function sync()
    {

    }

    /**
     * {@inheritDoc}
     */
    public function findOneByEmail($email)
    {
        foreach ($this->users as $user) {
            if ($user->getEmail() === $email) {
                return $user;
            }
        }
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function findOneByUsername($username)
    {
        foreach ($this->users as $user) {
            if ($user->getUsername() === $username) {
                return $user;
            }
        }
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function flush()
    {
        $this->users = array();
    }

}
