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


/**
 * Interactor used to create a user
 */
class Interaction {

    private $userRepository = null;
    private $rolesRepository = null;
    private $userRolesRepository = null;
    private $hasher = null;
    private $codeGenerator = null;

    /**
     * @param \OpenTribes\Core\User\Repository $userRepository
     * @param \OpenTribes\Core\Role\Repository $rolesRepo
     * @param \OpenTribes\Core\User\Role\Repository $userRolesRepository
     * @param \OpenTribes\Core\Service\Hasher $hasher
     * @param \OpenTribes\Core\Service\CodeGenerator $codeGenerator
     * @param \OpenTribes\Core\User\Validator $userValidator
     */
    public function __construct(UserRepository $userRepository, RolesRepository $rolesRepo, UserRoleRepository $userRolesRepository, Hasher $hasher, CodeGenerator $codeGenerator) {
        $this->userRepository = $userRepository;
        $this->rolesRepository = $rolesRepo;
        $this->userRolesRepository = $userRolesRepository;
        $this->hasher = $hasher;
        $this->codeGenerator = $codeGenerator;
    }

    /**
     * @param \OpenTribes\Core\User\Create\Request $request
     * @return \OpenTribes\Core\User\Create\Response
     */
    public function invoke(Request $request) {
        $value = $request->getUserValue();

      
        $id = $this->userRepository->getUniqueId();
        $passwordHash = $this->hasher->hash($value->getPassword());
        $activationCode = $this->codeGenerator->create();

        $user = new User($id, $value->getUsername(), $passwordHash, $value->getEmail());
        $user->setActivationCode($activationCode);

        $role = $this->rolesRepository->findByName($request->getRoleName());
        $userRole = new UserRole($user, $role);
        $user->addRole($userRole);

        $this->userRepository->add($user);
        $this->userRolesRepository->add($userRole);

        return new Response($user);
    }

}