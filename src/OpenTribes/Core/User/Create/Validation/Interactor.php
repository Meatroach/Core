<?php

/**
 * This file is part of the "Open Tribes" Core Module.
 *
 * @package    OpenTribes\Core
 * @author     Witali Mik <mik@blackscorp.de>
 * @copyright  (c) 2013 BlackScorp Games
 * @license    For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace OpenTribes\Core\User\Create\Validation;

use OpenTribes\Core\User\Create\Validator as UserValidator;


/**
 * Interactor used to create a user
 */
class Interactor {

    private $userRepository = null;
    private $userValidator = null;

    /**
     * @param \OpenTribes\Core\User\Repository $userRepository
     * @param \OpenTribes\Core\Role\Repository $rolesRepo
     * @param \OpenTribes\Core\User\Role\Repository $userRolesRepository
     * @param \OpenTribes\Core\Service\Hasher $hasher
     * @param \OpenTribes\Core\Service\CodeGenerator $codeGenerator
     * @param \OpenTribes\Core\User\Create\Validator $userValidator
     */
    public function __construct(UserRepository $userRepository, UserValidator $userValidator) {
        $this->userRepository = $userRepository;
        $this->userValidator = $userValidator;
    }

    /**
     * @param \OpenTribes\Core\User\Create\Request $request
     * @return \OpenTribes\Core\User\Create\Response
     * @throws UserCreateException
     */
    public function invoke(Request $request) {
        $userValue = $this->userValidator->getUserValue();
        $userValue
                ->setUsername($request->getUsername())
                ->setEmail($request->getEmail())
                ->setPassword($request->getPassword())
                ->setPasswordConfirmed($request->getPassword() === $request->getPasswordConfirm())
                ->setEmailConfirmed($request->getEmail() === $request->getEmailConfirm())
                ->setIsUniqueUsername($this->userRepository->usernameExists($request->getUsername()))
                ->setIsUniqueEmail($this->userRepository->emailExists($request->getEmail()));

        if (!$this->userValidator->isValid()) { 
            throw new InvalidArgumentException('Invalid request');
        }
       

        return new Response($userValue);
    }

}