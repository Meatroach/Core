<?php

namespace OpenTribes\Core\Interactor;

use OpenTribes\Core\Repository\User as UserRepository;
use OpenTribes\Core\Request\ActivateUser as ActivateUserRequest;
use OpenTribes\Core\Response\ActivateUser as ActivateUserResponse;
use OpenTribes\Core\Validator\ActivateUser as ActivateUserValidator;

/**
 * Interactor to activate a user account
 *
 * @author BlackScorp<witalimik@web.de>
 */
class ActivateUser {

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var ActivateUserValidator
     */
    private $activateUserValidator;

    /**
     * @param \OpenTribes\Core\Repository\User $userRepository
     * @param \OpenTribes\Core\Validator\ActivateUser $activateUserValidator
     */
    public function __construct(UserRepository $userRepository, ActivateUserValidator $activateUserValidator) {
        $this->userRepository        = $userRepository;
        $this->activateUserValidator = $activateUserValidator;
    }

    /**
     *
     * @param \OpenTribes\Core\Request\ActivateUser $request
     * @param \OpenTribes\Core\Response\ActivateUser $response
     * @return boolean
     */
    public function process(ActivateUserRequest $request, ActivateUserResponse $response) {
        $object = $this->activateUserValidator->getObject();
        $user   = $this->userRepository->findOneByUsername($request->getUsername());

        if (!$user && !$this->activateUserValidator->isValid()) {
            $response->errors = $this->activateUserValidator->getErrors();
            return false;
        }
        $object->codeIsValid = $request->getActivationCode() === $user->getActivationCode();
        if (!$this->activateUserValidator->isValid()) {
            $response->errors = $this->activateUserValidator->getErrors();
            return false;
        }
        $user->setActivationCode(null);
        if(!$user){
            return false;
        }
        $this->userRepository->replace($user);
        $response->username = $user->getUsername();
        return true;
    }

}
