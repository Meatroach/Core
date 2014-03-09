<?php

namespace OpenTribes\Core\Domain\Context\Guest;

use OpenTribes\Core\Domain\Repository\User as UserRepository;
use OpenTribes\Core\Domain\Request\Registration as RegistrationRequest;
use OpenTribes\Core\Domain\Response\Registration as RegistrationResponse;
use OpenTribes\Core\Domain\Service\ActivationCodeGenerator;
use OpenTribes\Core\Domain\Service\PasswordHasher;
use OpenTribes\Core\Domain\Validator\Registration as RegistrationValidator;
use OpenTribes\Core\Domain\Request\CreateUser as CreateUserRequest;
use OpenTribes\Core\Domain\Interactor\CreateUser as CreateUserInteractor;
use OpenTribes\Core\Domain\Response\CreateUser as CreateUserResponse;
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
        $response->username           = $request->getUsername();
        $response->email              = $request->getEmail();
        $response->emailConfirm       = $request->getEmailConfirm();
        $response->password           = $request->getPassword();
        $response->passwordConfirm    = $request->getPasswordConfirm();
        $response->termsAndConditions = $request->getTermsAndConditions();
        
        if (!$this->registrationValidator->isValid()) {
            
            $response->errors = $this->registrationValidator->getErrors();
          
            return false;
        }
        $createUserRequest = new CreateUserRequest($request->getUsername(), $request->getPassword(), $request->getEmail());
        $createUserInteractor = new CreateUserInteractor($this->userRepository, $this->passwordHasher);
        $createUserResponse = new CreateUserResponse;
        $createUserInteractor->proccess($createUserRequest, $createUserResponse);
        $activationCode = $this->activationCodeGenerator->create();
        $user           = $this->userRepository->findOneByUsername($createUserResponse->username);
        
        $user->setActivationCode($activationCode);
        $this->userRepository->add($user);

        $response->activationCode = $user->getActivationCode();
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
