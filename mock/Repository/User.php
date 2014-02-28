<?php

namespace OpenTribes\Core\Mock\Repository;

use OpenTribes\Core\Domain\Entity\User as UserEntity;
use OpenTribes\Core\Domain\Repository\User as UserRepository;

/**
 * Description of User
 *
 * @author BlackScorp<witalimik@web.de>
 */
class User implements UserRepository {

    /**
     * @var UserEntity[] 
     */
    private $users    = array();
    private $added    = array();
    private $modified = array();
    private $deleted  = array();

    public function add(UserEntity $user) {
        $this->users[$user->getId()] = $user;
        $this->added[$user->getId()] = $user->getId();
    }

    public function create($id, $username, $password, $email) {
        return new UserEntity($id, $username, $password, $email);
    }

    public function delete(UserEntity $user) {
        unset($this->users[$user->getId()]);
        $this->deleted[$user->getId()] = $user->getId();
    }

    public function getUniqueId() {
        $amountOfUsers = count($this->users);
        return ++$amountOfUsers;
    }

    public function replace(UserEntity $user) {
        $this->users[$user->getId()]    = $user;
        $this->modified[$user->getId()] = $user->getId();
    }

    public function sync() {
        
    }
    /**
     * @param \string $email
     * @return null|UserEntity
     */
    public function findOneByEmail($email) {
        foreach($this->users as $user){
            if($user->getEmail() === $email) return $user;
        }
        return null;
    }
    /**
     * @param \string $username
     * @return null|UserEntity
     */
    public function findOneByUsername($username) {
        foreach($this->users as $user){
            if($user->getUsername() === $username) return $user;
        }
        return null;
    }
}
