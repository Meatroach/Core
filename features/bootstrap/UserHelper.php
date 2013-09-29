<?php

//Entities
use OpenTribes\Core\User;
use OpenTribes\Core\Role;
use OpenTribes\Core\User\Role as UserRole;

//Repositories
use OpenTribes\Core\Mock\User\Repository as UserRepository;
use OpenTribes\Core\Mock\Role\Repository as RoleRepository;
use OpenTribes\Core\Mock\User\Role\Repository as UserRoleRepository;

//Services
use OpenTribes\Core\Mock\Service\Md5Hasher as Hasher;
use OpenTribes\Core\Mock\Service\FileMailer as Mailer;
use OpenTribes\Core\Mock\Service\QwertyGenerator as Generator;

//Requests

//Interactors



require_once 'vendor/phpunit/phpunit/PHPUnit/Framework/Assert/Functions.php';

class UserHelper {

    protected $user;
    protected $roleRepository;
    protected $userRepository;
    protected $response;
    protected $codeGenerator;
    protected $exception = null;
    protected $mailer = null;
    protected $userRoleRepository;
 
    public function __construct(ExceptionHelper $exception) {
        $this->roleRepository = new RoleRepository();
        $this->userRepository = new UserRepository();
        $this->userRoleRepository = new UserRoleRepository();

        $this->hasher = new Hasher();
        $this->codeGenerator = new Generator();
        $this->mailer = new Mailer();
        $this->exception = $exception;
        $this->initRoles();
    }

    // Default Methods to initialize Data

    /**
     * Method to Init base Roles
     */
    private function initRoles() {
        
        $role = new Role();
        $role->setName('Guest');
        $this->roleRepository->add($role);
        $role = new Role();
        $role->setName('User');
        $this->roleRepository->add($role);
        $role = new Role();
        $role->setName('Admin');
        $this->roleRepository->add($role);
    }

    /**
     * Method to create empty user 
     */
    public function newUser() {
        $this->user = new User();
        $this->user->setRoles(new UserRoles());
    }

    /**
     * Methode to add a role to current user
     * @param String $name Rolename
     */
    public function addRole($name) {

        //Load guest role
        $role = $this->roleRepository->findByName($name);
        $userRole = new UserRole();
        $userRole->setUser($this->user);
        $userRole->setRole($role);
        $this->userRoleRepository->add($userRole);
    }

    /**
     * Method to create a DumpUsers, to simulate UserDatabase
     * @param array $data Userdata
     */
    public function createDumpUser(array $data) {
    
        foreach ($data as $row) {
            $user = new User();
           
            foreach($row as $field => $value){
                $user->{$field} = $value;
            }
            //hash password
            $user->setPasswordHash($this->hasher->hash($user->getPassword()));
            $roles = new UserRoles();

            $user->setRoles($roles);
            $this->userRepository->add($user);
        }
    }
    public function getUserRepository(){
        return $this->userRepository;
    }
  

    //Interactor tests
    /**
     * Method to create a user with an interactor
     * @param array $data Userdata
     */
    public function create(array $data) {
        foreach ($data as $row) {
            $request = new UserCreateRequest($row['username'], $row['password'], $row['email'], $row['password_confirm'], $row['email_confirm'], 'Guest');
        }

        $interactor = new UserCreateInteractor($this->userRepository, $this->roleRepository, $this->userRolesRepository, $this->hasher);
        try {
            $this->response = $interactor($request);
        } catch (\Exception $e) {
            $this->exception->setException($e);
        }
    }

    /**
     * Method to login as registered User with an interactor
     * @param array $data Userdata
     */
    public function login(array $data) {

        foreach ($data as $row) {
            $request = new UserLoginRequest($row['Username'], $row['Password']);
        }
        $interactor = new UserLoginInteractor($this->userRepository, $this->hasher);

        try {
            $this->response = $interactor($request);
            $authRequest = new UserAuthenticateRequest($this->response->getUser(), 'User');
            $authInteractor = new UserAuthenticateInteractor($this->userRepository, $this->roleRepository, $this->userRolesRepository);
        
            $this->response = $authInteractor($authRequest);
        
        } catch (\Exception $e) {
            $this->exception->setException($e);
        }
    }

    /**
     * Method to send an Activation Mail with an interactor
     * it use the response of UserCreateInteractor
     */
    public function sendActivationCode() {
        /**
         * @todo: have to refactor the activation mail part
        */
        $user = $this->response->getMailView()->getUser();

        $request = new SendActivationMailRequest($this->response->getMailView(), $user->getEmail(), $user->getUsername(), 'Activate Account');
        $interactor = new SendActivationMailInteractor($this->mailer);
        $this->response = $interactor($request);
        assertTrue($this->response->getResult());
    }

    /**
     * Method to activate account and set a role for an active use with an interactor
     * @param array $data Userdata
     */
    public function activateAccount(array $data) {
        foreach ($data as $row) {
            $request = new UserActivateRequest($row['username'], $row['activation_code'], 'User');
        }
        $interactor = new UserActivateInteractor($this->userRepository, $this->roleRepository, $this->userRolesRepository);
        try {
            $this->response = $interactor($request);
        } catch (\Exception $e) {
            $this->exception->setException($e);
        }
    }

    //Assertion Methods for testing
    /**
     * Assert Login was successfull
     */
    public function assertIsLoginResponse() {
        assertInstanceOf('\OpenTribes\Core\User\Authenticate\Response', $this->response);

        assertNotNull($this->response->getUser()->getId());
    }

    /**
     * Assert Create Account was successfull
     */
    public function assertIsCreateResponse() {
        assertInstanceOf('\OpenTribes\Core\User\Create\Response', $this->response);
        assertNotNull($this->userRepository->findById($this->response->getUser()->getId()));
    }

    /**
     * Assert an activation code mail was created with an interactor
     */
    public function assertHasActivationCode() {
        $request = new CreateActivationMailRequest($this->response->getUser());
        $interactor = new CreateActivationMailInteractor($this->userRepository, $this->codeGenerator);
        $this->response = $interactor($request);
        assertInstanceOf('\OpenTribes\Core\User\ActivationMail\Create\Response', $this->response);
        assertNotNull($this->response->getMailView()->getUser()->getActivationCode());
    }

  

    /**
     * Assert account is activated
     */
    public function assertActivated() {
        $user = $this->response->getUser();
        assertInstanceOf('\OpenTribes\Core\User\Activate\Response', $this->response);
        assertEmpty($user->getActivationCode());
    }

    /**
     * Assert account has role
     * @param String $role Role
     */
    public function assertHasRole($role) {
        $user = $this->response->getUser();
     
        assertTrue($user->getRoles()->hasRole($role));
    }
   
}

?>
