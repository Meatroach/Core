<?php

namespace OpenTribes\Core\Domain\Context\Guest;

use OpenTribes\Core\Domain\Repository\User as UserRepository;
use OpenTribes\Core\Domain\Request\Registration as RegistrationRequest;
use OpenTribes\Core\Domain\Response\Registration as RegistrationResponse;
use OpenTribes\Core\Domain\Validator\Registration as RegistrationValidator;

/**
 * Description of Registration
 *
 * @author BlackScorp<witalimik@web.de>
 */
class Registration {

    private $userRepository;
    private $registrationValidator;

    function __construct(UserRepository $userRepository, RegistrationValidator $registrationValidator) {
        $this->userRepository        = $userRepository;
        $this->registrationValidator = $registrationValidator;
    }

    public function process(RegistrationRequest $request, RegistrationResponse $response) {
        $this->assignInputToValidator($request);
        
        if (!$this->registrationValidator->isValid()) {
            $response->errors    = $this->registrationValidator->getErrors();
            return false;
        }
       
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
