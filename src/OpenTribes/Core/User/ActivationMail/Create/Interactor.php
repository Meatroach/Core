<?php

namespace OpenTribes\Core\User\ActivationMail\Create;

use OpenTribes\Core\User\ActivationMail\Repository as ActivationMailRepository;

class Interactor{
    protected $activationMailRepository;
    
    public function __construct(ActivationMailRepository $activationMailRepository){
        $this->activationMailRepository = $activationMailRepository;
    }
    public function invoke(Request $request) {
        
        $user = $request->getUser();
        $activationMail = $this->activationMailRepository->create();
        $activationMail->setEmail($user->getEmail());
        $activationMail->setActivationCode($user->getActivationCode());
        $activationMail->setUsername($user->getUsername());
        
        
       return new Response($activationMail);
    }
}
