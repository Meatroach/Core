<?php

namespace OpenTribes\Core\Guest\Account\Create;

//Repositories
use OpenTribes\Core\User\Repository as UserRepository;
use OpenTribes\Core\User\Role\Repository as UserRoleRepository;
use OpenTribes\Core\Role\Repository as RoleRepository;
use OpenTribes\Core\User\Activation\Mail\Repository as ActivationMailRepository;

//Services
use OpenTribes\Core\Service\CodeGenerator;
use OpenTribes\Core\Service\Hasher;

use OpenTribes\Core\User\Create\Validation\Validator;
//Requests and Interactions
use OpenTribes\Core\User\Create\Validation\Request as UserCreateValidationRequest;
use OpenTribes\Core\User\Create\Validation\Interaction as UserCreateValidationInteraction;
use OpenTribes\Core\User\Activation\Create\Request as UserActivationCreateRequest;
use OpenTribes\Core\User\Activation\Create\Interaction as UserActivationCreateInteraction;


class Context {

    protected $userRepository;
    protected $roleRepository;
    protected $userRoleRepository;
    protected $activationMailRepository;
    protected $codeGenerator;
    protected $passwordHasher;
    protected $mailSender;
    protected $userCreateValidator;

    public function __construct(
    UserRepository $userRepository, UserRoleRepository $userRoleRepository, RoleRepository $roleRepository, ActivationMailRepository $activationMailRepository, CodeGenerator $codeGenerator, Hasher $passwordHasher, Validator $userCreateValidator
    ) {
        $this->userRepository = $userRepository;
        $this->userRoleRepository = $userRoleRepository;
        $this->roleRepository = $roleRepository;
        $this->activationMailRepository = $activationMailRepository;
        $this->codeGenerator = $codeGenerator;
        $this->passwordHasher = $passwordHasher;
        $this->userCreateValidator = $userCreateValidator;
    }

    public function invoke(Request $request) {
        //Validate Input
        $userCreateValidationRequest = new UserCreateValidationRequest(
                $request->getUsername(), $request->getPassword(), $request->getEmail(), $request->getPasswordConfirm(), $request->getEmailConfirm(), $request->getAcceptTermsAndConditions()
        );
        $userCreateValidationInteraction = new UserCreateValidationInteraction(
                $this->userRepository, $this->userCreateValidator
        );

        $userCreateValidationResponse = $userCreateValidationInteraction->invoke($userCreateValidationRequest);

        //Create User
        $userCreateRequest = new UserCreateRequest(
                $userCreateValidationResponse->getUsername(), $userCreateValidationResponse->getEmail(), $userCreateValidationResponse->getPassword(), $request->getDefaultRolename()
        );

        $userCreateInteraction = new UserCreateInteraction(
                $this->userRepository, $this->roleRepository, $this->userRoleRepository, $this->passwordHasher
        );

        $userCreateResponse = $userCreateInteraction->invoke($userCreateRequest);
        //Create activation code 
        $activationMailCreateRequest = new UserActivationCreateRequest($userCreateResponse->getUser());

        $activationMailCreateInteraction = new UserActivationCreateInteraction($this->activationMailRepository, $this->codeGenerator, $this->userRepository);
        $activationMailCreateResponse = $activationMailCreateInteraction->invoke($activationMailCreateRequest);

        return new Response($activationMailCreateResponse);
    }

}