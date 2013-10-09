<?php

namespace OpenTribes\Core\User\ActivationMail\Create;

use OpenTribes\Core\User\Repository as UserRepository;
use OpenTribes\Core\Service\CodeGenerator;
use OpenTribes\Core\User\ActivationMail\View\Mail;

class Interactor{
    protected $userRepository;
    protected $codeGenerator;
    
    public function __construct(UserRepository $userRepository,  CodeGenerator $codeGenerator){
        $this->userRepository = $userRepository;
        $this->codeGenerator = $codeGenerator;
    }
    public function execute(Request $request) {
        $code = $this->codeGenerator->create();
        $user = $request->getUser();
        $user->setActivationCode($code);
        $this->userRepository->add($user);
        
        
        return new Response(new Mail($user));
    }
}
