<?php

namespace OpenTribes\Core\User\Activate;

use OpenTribes\Core\User\Repository as UserRepository;
use OpenTribes\Core\User\Role\Repository as UserRoleRepository;
use OpenTribes\Core\Role\Repository as RoleRepository;

use OpenTribes\Core\User\Role as UserRoles;

use OpenTribes\Core\User\Activate\Exception\NotExists as NotExistsException;
use OpenTribes\Core\User\Activate\Exception\Invalid as InvalidCodeException;
use OpenTribes\Core\User\Activate\Exception\Active as AlreadyActiveException;

use OpenTribes\Core\Interactor as BaseInteractor;

class Interactor extends BaseInteractor {

    protected $userRepository;
    protected $userRolesRepository;
    protected $roleRepository;

    public function __construct(UserRepository $userRepository, 
            RoleRepository $roleRepository, 
            UserRoleRepository $userRolesRepository) {
        $this->userRepository = $userRepository;
        $this->userRoleRepository = $userRolesRepository;
        $this->roleRepository = $roleRepository;
    }

    public function __invoke(Request $request) {
        $user = $this->userRepository->findByUsername($request->getUsername());
       
        $role = $this->roleRepository->findByName($request->getRolename());
        if (!$user)
            throw new NotExistsException;
        if (!((bool) $user->getActivationCode()))
            throw new AlreadyActiveException;
        if ($user->getActivationCode() !== $request->getCode())
            throw new InvalidCodeException;

        $user->setActivationCode('');
        $userRole = new UserRoles();
        $userRole->setRole($role);
        $userRole->setUser($user);
       

        

        $this->userRepository->add($user);
        $this->userRoleRepository->add($userRole);

        return new Response($user);
    }

}