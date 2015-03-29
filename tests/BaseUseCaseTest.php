<?php

namespace OpenTribes\Core\Test;


use OpenTribes\Core\Repository\UserRepository;

abstract class BaseUseCaseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var UserRepository
     */
    protected $userRepository;
    protected function createDummyUser()
    {
        $userId = $this->userRepository->getUniqueId();
        $user = $this->userRepository->create($userId, 'Dummy', '123456', 'dummy@test.com');
        $this->userRepository->add($user);
        return $user;
    }
}