<?php

namespace OpenTribes\Core\Domain\Context\Guest;

use OpenTribes\Core\Domain\Repository\User as UserRepository;
use OpenTribes\Core\Domain\Request\Registration as RegistrationRequest;
use OpenTribes\Core\Domain\Response\Registration as RegistrationResponse;
use OpenTribes\Core\Domain\Service\ActivationCodeGenerator;
use OpenTribes\Core\Domain\Service\PasswordHasher;
use OpenTribes\Core\Domain\Validator\Registration as RegistrationValidator;

/**
 * Description of Registration
 *
 * @author BlackScorp<witalimik@web.de>
 */
class Registration {

    private $userRepository;
    private $registrationValidator;
    private $passwordHasher;
    private $activationCodeGenerator;

    function __construct(UserRepository $userRepository, RegistrationValidator $registrationValidator, PasswordHasher $passwordHasher, ActivationCodeGenerator $activationCodeGenerator) {
        $this->userRepository          = $userRepository;
        $this->registrationValidator   = $registrationValidator;
        $this->passwordHasher          = $passwordHasher;
        $this->activationCodeGenerator = $activationCodeGenerator;
    }

    public function process(RegistrationRequest $request, RegistrationResponse $response) {
        $this->assignInputToValidator($request);

        if (!$this->registrationValidator->isValid()) {
            $response->errors = $this->registrationValidator->getErrors();
            return false;
        }
        $id             = $this->userRepository->getUniqueId();
        $password       = $this->passwordHasher->hash($request->getPassword());
        $activationCode = $this->activationCodeGenerator->create();
        $user           = $this->userRepository->create($id, $request->getUsername(), $password, $request->getEmail());
        $user->setActivationCode($activationCode);
        $this->userRepository->add($user);
        
        return true;
    }

    private function assignInputToValidator(RegistrationRequest $request) {
        $validationObject                     = $this->registrationValidator->getObject();
        $validationObject->email              = $request->getEmail();
        $validationObject->emailConfirm       = $request->getEmailConfirm();
        $validationObject->password           = $request->getPassword();
        $validationObject->passwordConfirm    = $request->getPasswordConfirm();
        $validationObject->username           = $request->getUsername();
        $validationObject->termsAndConditions = $request->getTermsAndConditions();
        $validationObject->isUniqueEmail      = !(bool) $this->userRepository->findOneByEmail($request->getEmail());
        $validationObject->isUniqueUsername   = !(bool) $this->userRepository->findOneByUsername($request->getUsername());
    }

}
