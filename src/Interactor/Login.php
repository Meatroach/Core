<?php

namespace OpenTribes\Core\Interactor;

use OpenTribes\Core\Repository\User as UserRepository;
use OpenTribes\Core\Request\Login as LoginRequest;
use OpenTribes\Core\Response\Login as LoginResponse;
use OpenTribes\Core\Service\PasswordHasher;
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
        $response->username = $request->getUsername();
        $response->password = $request->getPassword();
        $user = $this->userRepository->findOneByUsername($request->getUsername());
        if(!$user || $user->getActivationCode()) return false;
       
        return $this->passwordHasher->verify($user->getPassword(), $request->getPassword());
        
    }
}
