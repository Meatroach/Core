<?php

use OpenTribes\Core\Domain\Repository\User as UserRepository;

class UserHelper {

    private $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function createDummyAccount($username, $password, $email) {
        $userId = $this->userRepository->getUniqueId();
        $user   = $this->userRepository->create($userId, $username, $password, $email);
        $this->userRepository->add($user);
    }

}
