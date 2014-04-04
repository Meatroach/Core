<?php

namespace OpenTribes\Core\Interactor;
use OpenTribes\Core\Request\CreateUser as CreateUserRequest;
use OpenTribes\Core\Response\CreateUser as CreateUserResponse;
use OpenTribes\Core\Repository\User as UserRepository;
use OpenTribes\Core\Service\PasswordHasher;
/**
 * Interactor to Create a user account and hash the password
 *
 * @author BlackScorp<witalimik@web.de>
 */
class CreateUser {

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var PasswordHasher
     */
    private $passwordHasher;

    /**
     * @param \OpenTribes\Core\Repository\User $userRepository
     * @param \OpenTribes\Core\Service\PasswordHasher $passwordHasher
     */
    function __construct(UserRepository $userRepository,PasswordHasher $passwordHasher) {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
    }

    /**
     *
     * @param \OpenTribes\Core\Request\CreateUser $request
     * @param \OpenTribes\Core\Response\CreateUser $response
     * @return boolean
     */
    public function proccess(CreateUserRequest $request,CreateUserResponse $response){
        $userId = $this->userRepository->getUniqueId();
        $password = $this->passwordHasher->hash($request->getPassword());
        $user = $this->userRepository->create($userId, $request->getUsername(), $password, $request->getEmail());
        $this->userRepository->add($user);
        $response->username = $user->getUsername();
        return true;
    }
            
}
