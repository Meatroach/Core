<?php

namespace OpenTribes\Core\Interactor;
use OpenTribes\Core\Request\CreateUser as CreateUserRequest;
use OpenTribes\Core\Response\CreateUser as CreateUserResponse;
use OpenTribes\Core\Repository\User as UserRepository;
use OpenTribes\Core\Service\PasswordHasher;
/**
 * Description of CreateUser
 *
 * @author BlackScorp<witalimik@web.de>
 */
class CreateUser {
    private $userRepository;
    private $passwordHasher;
    function __construct(UserRepository $userRepository,PasswordHasher $passwordHasher) {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
    }
    public function proccess(CreateUserRequest $request,CreateUserResponse $response){
        $userId = $this->userRepository->getUniqueId();
        $password = $this->passwordHasher->hash($request->getPassword());
        $user = $this->userRepository->create($userId, $request->getUsername(), $password, $request->getEmail());
        $this->userRepository->add($user);
        $response->username = $user->getUsername();
        return true;
    }
            
}
