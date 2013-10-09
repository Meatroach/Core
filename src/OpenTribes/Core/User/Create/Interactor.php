<?php

namespace OpenTribes\Core\User\Create;

use OpenTribes\Core\Message;
use OpenTribes\Core\User\Role as UserRole;

use OpenTribes\Core\User\Repository as UserRepository;
use OpenTribes\Core\Role\Repository as RolesRepository;
use OpenTribes\Core\User\Role\Repository as UserRoleRepository;
use OpenTribes\Core\Message\Repository as MessageRepository;

use OpenTribes\Core\Service\Hasher;
use OpenTribes\Core\Service\CodeGenerator;

use OpenTribes\Core\User\Create\Exception as UserCreateException;

class Interactor {

    private $userRepository = null;
    private $rolesRepository = null;
    private $userRolesRepository = null;
    private $hasher = null;
    private $codeGenerator = null;
    private $messageRepository = null;

    public function __construct(UserRepository $userRepository, RolesRepository $rolesRepo, UserRoleRepository $userRolesRepository, Hasher $hasher, CodeGenerator $codeGenerator, MessageRepository $messageRepository) {
        $this->userRepository = $userRepository;
        $this->rolesRepository = $rolesRepo;
        $this->userRolesRepository = $userRolesRepository;
        $this->hasher = $hasher;
        $this->codeGenerator = $codeGenerator;
        $this->messageRepository = $messageRepository;
    }

    public function invoke(Request $request) {
        $user = $this->userRepository->create($this->messageRepository);

        $user->setPassword($request->getPassword());
        $user->setUsername($request->getUsername());
        $user->setEmail($request->getEmail());

        if ($this->userRepository->findByUsername($request->getUsername()))
            $this->messageRepository->add(new Message('Username already exists'));
        if ($this->userRepository->findByEmail($request->getEmail()))
            $this->messageRepository->add(new Message('Email address already exists'));

        if ($request->getEmail() !== $request->getEmailConfirm())
            $this->messageRepository->add(new Message('email confirm not match email'));
        if ($request->getPassword() !== $request->getPasswordConfirm())
            $this->messageRepository->add(new Message('password confirm not match password'));

        if (count($this->messageRepository->findAll()) > 0)
            throw new UserCreateException();


        $role = $this->rolesRepository->findByName($request->getRoleName());
        $user->setActivationCode($this->codeGenerator->create());
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