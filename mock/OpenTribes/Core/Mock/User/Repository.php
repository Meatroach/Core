<?php

namespace OpenTribes\Core\Mock\User;

use OpenTribes\Core\User\Repository as UserRepositoryInterface;
use OpenTribes\Core\User;

class Repository implements UserRepositoryInterface {

    private $users = array();

    public function add(User $user) {
        $this->users[$user->getUsername()] = $user;
    }

    public function create() {
        return new User();
    }

    public function findByEmail($email) {
        foreach ($this->users as $user) {
            if ($user->getEmail() === $email) {
                return $user;
            }
        };
    }

    public function findByUsername($username) {
        return isset($this->users[$username]) ? $this->users[$username] : null;
    }

}