<?php

namespace OpenTribes\Core\Guest\Account;

use OpenTribes\Core\User;
use OpenTribes\Core\Role;
use OpenTribes\Core\User\Role as UserRole;
use OpenTribes\Core\User\ActivationMail;
//Repositories
use OpenTribes\Core\User\Repository as UserRepository;
use OpenTribes\Core\Role\Repository as RoleRepository;
use OpenTribes\Core\User\Role\Repository as UserRoleRepository;
use OpenTribes\Core\User\ActivationMail\Repository as ActivationMailRepository;
//Services
use OpenTribes\Core\Service\CodeGenerator;
use OpenTribes\Core\Service\Hasher as PasswordHasher;
use OpenTribes\Core\Service\Mailer as MailerSender;
//Validators
use OpenTribes\Core\User\Create\Validator;
//Requests
use OpenTribes\Core\User\Create\Validation\Request as UserCreateValidationRequest;
use \OpenTribes\Core\User\Create\Request as UserCreateRequest;

class Create {

    private $userRepository;
    private $roleRepository;
    private $userRoleRepository;
    private $activationMailRepository;
    private $codeGenerator;
    private $passwordHasher;
    private $mailSender;
    private $validator;

    public function __construct(UserRepository $userRepository,
            RoleRepository $roleRepository,
            UserRoleRepository $userRoleRepository,
            ActivationMailRepository $activationMailRepository,
            CodeGenerator $codeGenerator,
            PasswordHasher $passwordHasher,
            MailerSender $mailSender,
            Validator $validator) {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->userRoleRepository = $userRoleRepository;
        $this->activationMailRepository = $activationMailRepository;
        $this->codeGenerator = $codeGenerator;
        $this->passwordHasher = $passwordHasher;
        $this->mailSender = $mailSender;
        $this->validator = $validator;
    }

    public function invoke(Request $request) {

        $userCreateValidationRequest = new UserCreateValidationRequest($request->getUsername(), $request->getPassword(), $request->getEmail(), $request->getPasswordConfirm(), $request->getEmailConfirm(), $request->getTermsAndConditions());

        $userCreateValidationInteractor = new UserCreateValidationInteractor($this->userRepository, $this->validator);

        $userCreateInteractor = new UserCreateInteractor(
                $this->userRepository, $this->roleRepository, $this->userRoleRepository, $this->passwordHasher, $this->codeGenerator
        );

        $activationMailCreateInteractor = new ActivationMailCreateInteractor($this->activationMailRepository);
        $activationMailSendInteractor = new ActivationMailSendInteractor($this->mailer);


        $this->userCreateValidationResponse = $userCreateValidationInteractor->invoke($userCreateValidationRequest);
        //create user account
        $userCreateRequest = new UserCreateRequest($this->userCreateValidationResponse, $request->getRolename());
        $this->userCreateResponse = $userCreateInteractor->invoke($userCreateRequest);
        //Create activation Mail
        $activationMailCreateRequest = new ActivationMailCreateRequest($this->userCreateResponse);
        $this->activationMailCreateResponse = $activationMailCreateInteractor->invoke($activationMailCreateRequest);
        //Modify and send Activation Mail
        $activationMailSendRequest = new ActivationMailSendRequest($this->activationMailCreateResponse);
        $this->activationMailSendResponse = $activationMailSendInteractor->invoke($activationMailSendRequest);
    }

}
