<?php

/**
 * This file is part of the "Open Tribes" Core Module.
 *
 * @package    OpenTribes\Core
 * @author     Witali Mik <mik@blackscorp.de>
 * @copyright  (c) 2013 BlackScorp Games
 * @license    For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace OpenTribes\Core\User\Create;

use OpenTribes\Core\User;
use OpenTribes\Core\User\Role as UserRole;
use OpenTribes\Core\User\Repository as UserRepository;
use OpenTribes\Core\Role\Repository as RolesRepository;
use OpenTribes\Core\User\Role\Repository as UserRoleRepository;
use OpenTribes\Core\Service\Hasher;
use OpenTribes\Core\Service\CodeGenerator;
use OpenTribes\Core\User\Validator as UserValidator;
use OpenTribes\Core\User\Create\Exception as UserCreateException;

/**
 * Interactor used to create a user
 */
class Interactor {

    private $userRepository = null;
    private $rolesRepository = null;
    private $userRolesRepository = null;
    private $hasher = null;
    private $codeGenerator = null;
    private $userValidator = null;

    /**
     * @param \OpenTribes\Core\User\Repository $userRepository
     * @param \OpenTribes\Core\Role\Repository $rolesRepo
     * @param \OpenTribes\Core\User\Role\Repository $userRolesRepository
     * @param \OpenTribes\Core\Service\Hasher $hasher
     * @param \OpenTribes\Core\Service\CodeGenerator $codeGenerator
     * @param \OpenTribes\Core\User\Validator $userValidator
     */
    public function __construct(UserRepository $userRepository, RolesRepository $rolesRepo, UserRoleRepository $userRolesRepository, Hasher $hasher, CodeGenerator $codeGenerator, UserValidator $userValidator) {
        $this->userRepository = $userRepository;
        $this->rolesRepository = $rolesRepo;
        $this->userRolesRepository = $userRolesRepository;
        $this->hasher = $hasher;
        $this->codeGenerator = $codeGenerator;
        $this->userValidator = $userValidator;
    }

    /**
     * @param \OpenTribes\Core\User\Create\Request $request
     * @return \OpenTribes\Core\User\Create\Response
     * @throws UserCreateException
     */
    public function invoke(Request $request) {
        
        $this->userValidator
                ->setUsername($request->getUsername())
                ->setEmail($request->getEmail())
                ->setPassword($request->getPassword())
                ->setPasswordConfirmed($request->getPassword() === $request->getPasswordConfirm())
                ->setEmailConfirmed($request->getEmail() === $request->getEmailConfirm())
                ->setIsUniqueUsername($this->userRepository->usernameExists($request->getUsername()))
                ->setIsUniqueEmail($this->userRepository->emailExists($request->getEmail()));

        if (!$this->userValidator->isValid()) {
        
            $userCreateException = new UserCreateException('Cannot create User');
            $userCreateException->setMessages( $this->userValidator->getErrors());
            throw $userCreateException;
        }
        $id = $this->userRepository->getUniqueId();
        $passwordHash = $this->hasher->hash($request->getPassword());
        $activationCode = $this->codeGenerator->create();

        $user = new User($id, $request->getUsername(), $passwordHash, $request->getEmail());
        $user->setActivationCode($activationCode);

        $role = $this->rolesRepository->findByName($request->getRoleName());
        $userRole = new UserRole($user, $role);
        $user->addRole($userRole);

        $this->userRepository->add($user);
        $this->userRolesRepository->add($userRole);

        return new Response($user);
    }

}