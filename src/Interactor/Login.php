<?php

namespace OpenTribes\Core\Domain\Interactor;

use OpenTribes\Core\Domain\Repository\User as UserRepository;
use OpenTribes\Core\Domain\Request\Login as LoginRequest;
use OpenTribes\Core\Domain\Response\Login as LoginResponse;
use OpenTribes\Core\Domain\Service\PasswordHasher;
/**
 * Description of Login
 *
 * @author BlackScorp<witalimik@web.de>
 */
class Login {
    private $userRepository;
    private $passwordHasher;
    function __construct(UserRepository $userRepository,PasswordHasher $passwordHasher) {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
    }
    public function process(LoginRequest $request,LoginResponse $response){
        $user = $this->userRepository->findOneByUsername($request->getUsername());
        if(!$user) return false;
        return $this->passwordHasher->verify($user->getPassword(), $request->getPassword());
        
    }
}
