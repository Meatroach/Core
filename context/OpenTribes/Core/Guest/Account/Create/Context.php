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
use OpenTribes\Core\User\Create\Validation\Request as CreateUserValidationRequest;
use OpenTribes\Core\User\Create\Validation\Interaction as CreateUserValidationInteraction;
use OpenTribes\Core\User\Create\Request as CreateUserRequest;
use OpenTribes\Core\User\Create\Interaction as CreateUserInteraction;
use OpenTribes\Core\User\Activation\Create\Request as CreateUserActivationCodeRequest;
use OpenTribes\Core\User\Activation\Create\Interaction as CreateUserActivationCodeInteraction;


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
   
        $createUserValidationRequest = new CreateUserValidationRequest(
                $request->getUsername(), $request->getPassword(), $request->getEmail(), $request->getPasswordConfirm(), $request->getEmailConfirm(), $request->getAcceptTermsAndConditions()
        );
        $createUserValidationInteraction = new CreateUserValidationInteraction(
                $this->userRepository, $this->userCreateValidator
        );

        $createUserValidationResponse = $createUserValidationInteraction->invoke($createUserValidationRequest);

  
        $createUserRequest = new CreateUserRequest(
                $createUserValidationResponse->getUsername(), $createUserValidationResponse->getEmail(), $createUserValidationResponse->getPassword(), $request->getDefaultRolename()
        );

        $createUserInteraction = new CreateUserInteraction(
                $this->userRepository, $this->roleRepository, $this->userRoleRepository, $this->passwordHasher
        );

        $createUserResponse = $createUserInteraction->invoke($createUserRequest);
 
        $createUserActivationCodeRequest = new CreateUserActivationCodeRequest($createUserResponse->getUser());

        $createUserActivationCodeInteraction = new CreateUserActivationInteraction($this->activationMailRepository, $this->codeGenerator, $this->userRepository);
        $createActivationCodeResponse = $createUserActivationCodeInteraction->invoke($createUserActivationCodeRequest);

        return new Response($createActivationCodeResponse);
    }

}