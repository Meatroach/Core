<?php

use OpenTribes\Core\Domain\Repository\User as UserRepository;

class UserHelper {

    private $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function createDummyAccount($username, $password, $email,$activationCode = null) {
        $userId = $this->userRepository->getUniqueId();
        $user   = $this->userRepository->create($userId, $username, $password, $email);
        if($activationCode){
            $user->setActivationCode($activationCode);
        }
        $this->userRepository->add($user);
    }
    public function activateUser($username){
        $user = $this->userRepository->findOneByUsername($username);
        $user->setActivationCode(null);
        $this->userRepository->replace($user);
    }
}
