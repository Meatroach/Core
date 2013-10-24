<?php

namespace OpenTribes\Core\Account\Create;

use OpenTribes\Core\User\Role as UserRole;
use OpenTribes\Core\User\Repository as UserRepository;
use OpenTribes\Core\User\Role\Repository as UserRoleRepository;
use OpenTribes\Core\Role\Repository as RoleRepository;
use OpenTribes\Core\User\Activation\Mail\Repository as ActivationMailRepository;

use OpenTribes\Core\Service\CodeGenerator;
use OpenTribes\Core\Service\MailSender;
use OpenTribes\Core\Service\Hasher;
use OpenTribes\Core\User\Create\Validation\Validator;

//Requests and Interactions
use OpenTribes\Core\User\Create\Validation\Request as UserCreateValidationRequest;
use OpenTribes\Core\User\Create\Validation\Interaction as UserCreateValidationInteractor;
use OpenTribes\Core\User\Activation\Create\Request as UserActivationCreateRequest;
use OpenTribes\Core\User\Activation\Create\Interaction as UserActivationCreateInteractor;
use OpenTribes\Core\User\Activation\Send\Request as UserActivationSendRequest;
use OpenTribes\Core\User\Activation\Send\Interaction as UserActivationSendInteractor;

class Context {

    private $userRepository;
    private $roleRepository;
    private $userRoleRepository;
    private $activationMailRepository;
    private $codeGenerator;
    private $passwordHasher;
    private $mailSender;
    private $userCreateValidator;

    public function __construct(
            UserRepository $userRepository,
            UserRoleRepository $userRoleRepository,
            RoleRepository $roleRepository,
            ActivationMailRepository $activationMailRepository,
            CodeGenerator $codeGenerator,
            Hasher $passwordHasher,
            MailSender $mailSender,
            Validator $userCreateValidator
    ) {
        $this->userRepository = $userRepository;
        $this->userRoleRepository = $userRoleRepository;
        $this->roleRepository = $roleRepository;
        $this->activationMailRepository = $activationMailRepository;
        $this->codeGenerator = $codeGenerator;
        $this->passwordHasher = $passwordHasher;
        $this->mailSender = $mailSender;
        $this->userCreateValidator = $userCreateValidator;
    }

    public function invoke(Request $request,
            UserRole $userRole) {

        $userCreateValidationRequest = new UserCreateValidationRequest($row['username'], $row['password'], $row['email'], $row['password_confirm'], $row['email_confirm']);
        $userCreateValidationInteractor = new UserCreateValidationInteractor($this->userRepository, $this->userValidator);

        $userCreateInteractor = new UserCreateInteractor(
                $this->userRepository, $this->roleRepository, $this->userRoleRepository, $this->hasher, $this->codeGenerator
        );
        $activationMailCreateInteractor = new ActivationMailCreateInteractor($this->activationMailRepository);
        $activationMailSendInteractor = new ActivationMailSendInteractor($this->mailer);

        $this->userCreateValidationResponse = $userCreateValidationInteractor->invoke($userCreateValidationRequest);
        //create user account
        $userCreateRequest = new UserCreateRequest($this->userCreateValidationResponse, 'Guest');
        $this->userCreateResponse = $userCreateInteractor->invoke($userCreateRequest);
        //Create activation Mail
        $activationMailCreateRequest = new ActivationMailCreateRequest($this->userCreateResponse);
        $this->activationMailCreateResponse = $activationMailCreateInteractor->invoke($activationMailCreateRequest);
        //Modify and send Activation Mail
        $activationMailSendRequest = new ActivationMailSendRequest($this->activationMailCreateResponse);
        $this->activationMailSendResponse = $activationMailSendInteractor->invoke($activationMailSendRequest);
    }

}