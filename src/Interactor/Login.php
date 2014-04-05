<?php

namespace OpenTribes\Core\Interactor;

use OpenTribes\Core\Repository\User as UserRepository;
use OpenTribes\Core\Request\Login as LoginRequest;
use OpenTribes\Core\Response\Login as LoginResponse;
use OpenTribes\Core\Service\PasswordHasher;
/**
 * Interactor to verify password for active user
 *
 * @author BlackScorp<witalimik@web.de>
 */
class Login {

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
    public function __construct(UserRepository $userRepository,PasswordHasher $passwordHasher) {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @param \OpenTribes\Core\Request\Login $request
     * @param \OpenTribes\Core\Response\Login $response
     * @return boolean
     */
    public function process(LoginRequest $request,LoginResponse $response){
        $response->username = $request->getUsername();
        $response->password = $request->getPassword();
        $user = $this->userRepository->findOneByUsername($request->getUsername());
        if(!$user || $user->getActivationCode()) return false;
       
        return $this->passwordHasher->verify($user->getPassword(), $request->getPassword());
        
    }
}
