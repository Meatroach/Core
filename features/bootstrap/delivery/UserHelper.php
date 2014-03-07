<?php

class DeliveryUserHelper {

    private $userRepository;
    private $registrationValidator;
    private $passwordHasher;
    private $activationCodeGenerator;
    private $registrationResponse;

    public function __construct(UserRepository $userRepository, RegistrationValidator $registrationValidator, PasswordHasher $passwordHasher,
            ActivationCodeGenerator $activationCodeGenerator) {
        $this->userRepository          = $userRepository;
        $this->registrationValidator   = $registrationValidator;
        $this->passwordHasher          = $passwordHasher;
        $this->activationCodeGenerator = $activationCodeGenerator;
    }

    public function processRegistration($username, $email, $emailConfirm, $password, $passwordConfirm, $termsAndConditions) {
        
    }

}
