<?php

use OpenTribes\Core\Domain\Repository\User as UserRepository;
use OpenTribes\Core\Domain\Validator\Registration as RegistrationValidator;
use OpenTribes\Core\Domain\Service\PasswordHasher;
use OpenTribes\Core\Domain\Service\ActivationCodeGenerator;
use OpenTribes\Core\Domain\Context\Guest\Registration as RegistrationContext;
use OpenTribes\Core\Domain\Request\Registration as RegistrationRequest;
use OpenTribes\Core\Domain\Response\Registration as RegistrationResponse;

class UserHelper {

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
        $request                    = new RegistrationRequest($username, $email, $emailConfirm, $password, $passwordConfirm, $termsAndConditions);
        $interaction                = new RegistrationContext($this->userRepository, $this->registrationValidator, $this->passwordHasher,
                $this->activationCodeGenerator);
        $this->registrationResponse = new RegistrationResponse;
        return $interaction->process($request, $this->registrationResponse);
    }

    public function getRegistrationResponse() {
        return $this->registrationResponse;
    }

    public function createDummyAccount($username, $password, $email, $activationCode = null) {
        $userId = $this->userRepository->getUniqueId();
        $user   = $this->userRepository->create($userId, $username, $password, $email);
        if ($activationCode) {
            $user->setActivationCode($activationCode);
        }
        $this->userRepository->add($user);
    }

    public function activateUser($username) {
        $user = $this->userRepository->findOneByUsername($username);
        $user->setActivationCode(null);
        $this->userRepository->replace($user);
    }

}
