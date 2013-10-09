<?php

namespace OpenTribes\Core\User\Create;


use OpenTribes\Core\User\Repository as UserRepository;
use OpenTribes\Core\Role\Repository as RolesRepository;
use OpenTribes\Core\User\Role\Repository as UserRoleRepository;
use OpenTribes\Core\Service\Hasher;
use OpenTribes\Core\User\Create\Exception\Email\Exists as EmailExistsException;
use OpenTribes\Core\User\Create\Exception\Email\Confirm as EmailConfirmException;
use OpenTribes\Core\User\Create\Exception\Username\Exists as UsernameExistsException;
use OpenTribes\Core\User\Create\Exception\Password\Confirm as PasswordConfirmException;
use OpenTribes\Core\User\Role as UserRole;
class Interactor {

    private $userRepository = null;
    private $rolesRepository = null;
    private $userRolesRepository = null;
    private $hasher = null;
    
    public function __construct(UserRepository $userRepository, RolesRepository $rolesRepo,UserRoleRepository $userRolesRepository, Hasher $hasher) {
        $this->userRepository = $userRepository;
        $this->rolesRepository = $rolesRepo;
        $this->userRolesRepository = $userRolesRepository;
        $this->hasher = $hasher;
    }

    public function __invoke(Request $request) {

     
        $user = $this->userRepository->create();
        $user->setPassword($request->getPassword());
        $user->setUsername($request->getUsername());
        $user->setEmail($request->getEmail());

        if ($this->userRepository->findByUsername($request->getUsername()))
            throw new UsernameExistsException;
        if ($this->userRepository->findByEmail($request->getEmail()))
            throw new EmailExistsException;

        if ($request->getEmail() !== $request->getEmailConfirm())
            throw new EmailConfirmException;
        if ($request->getPassword() !== $request->getPasswordConfirm())
            throw new PasswordConfirmException;
        
        $role = $this->rolesRepository->findByName($request->getRoleName());
        
        $user->setPasswordHash($this->hasher->hash($request->getPassword()));
        $userRole = new UserRole();
        $userRole->setRole($role);
        $userRole->setUser($user);
        $user->addRole($userRole);
        
        $this->userRepository->add($user);
        $this->userRolesRepository->add($userRole);
        
        return new Response($user);
    }

}