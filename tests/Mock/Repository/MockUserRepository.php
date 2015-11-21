<?php

namespace OpenTribes\Core\Test\Mock\Repository;

use OpenTribes\Core\Entity\UserEntity;
use OpenTribes\Core\Repository\UserRepository;


/**
 * Description of User
 *
 * @author BlackScorp<witalimik@web.de>
 */
class MockUserRepository implements UserRepository
{

    /**
     * @var UserEntity[]
     */
    private $users = array();


    /**
     * {@inheritDoc}
     */
    public function add(UserEntity $user)
    {
        $this->users[$user->getUserId()] = $user;

    }

    /**
     * @param $userId
     * @param $username
     * @param $passwordHash
     * @param $email
     * @return UserEntity
     */
    public function create($userId, $username, $passwordHash, $email)
    {
       $useEntity = new UserEntity($userId,$username,$passwordHash,$email);
        return $useEntity;
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
    public function findByEmail($email)
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
    public function findByUsername($username)
    {
        foreach ($this->users as $user) {
            if ($user->getUsername() === $username) {
                return $user;
            }
        }
        return null;
    }

    public function modify(UserEntity $user)
    {
        $this->users[$user->getUserId()] = $user;
    }

    public function delete(UserEntity $user)
    {
        unset($this->users[$user->getUserId()]);
    }


}
