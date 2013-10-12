<?php

//Entities
use OpenTribes\Core\User;
use OpenTribes\Core\Role;
use OpenTribes\Core\User\Role as UserRole;
//Repositories
use OpenTribes\Core\Mock\User\Repository as UserRepository;
use OpenTribes\Core\Mock\Role\Repository as RoleRepository;
use OpenTribes\Core\Mock\User\Role\Repository as UserRoleRepository;
use OpenTribes\Core\Mock\User\ActivationMail\Repository as ActivationMailRepository;
use OpenTribes\Core\Mock\Message\Repository as MessageRepository;
//Services
use OpenTribes\Core\Mock\Service\Md5Hasher as Hasher;
use OpenTribes\Core\Mock\Service\FileMailer as Mailer;
use OpenTribes\Core\Mock\Service\QwertyGenerator as Generator;
//Requests
use OpenTribes\Core\User\Create\Request as UserCreateRequest;
use OpenTribes\Core\User\Login\Request as UserLoginRequest;
use OpenTribes\Core\User\Activate\Request as UserActivateRequest;
use OpenTribes\Core\User\ActivationMail\Create\Request as ActivationMailCreateRequest;
use OpenTribes\Core\User\ActivationMail\Send\Request as ActivationMailSendRequest;
use OpenTribes\Core\User\Authenticate\Request as UserAuthenticateRequest;
//Interactors
use OpenTribes\Core\User\Create\Interactor as UserCreateInteractor;
use OpenTribes\Core\User\Login\Interactor as UserLoginInteractor;
use OpenTribes\Core\User\Activate\Interactor as UserActivateInteractor;
use OpenTribes\Core\User\ActivationMail\Create\Interactor as ActivationMailCreateInteractor;
use OpenTribes\Core\User\ActivationMail\Send\Interactor as ActivationMailSendInteractor;
use OpenTribes\Core\User\Authenticate\Interactor as UserAuthenticateInteractor;

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
    protected $messageRepository;
    protected $activationMailRepository;
    //responses
    protected $userCreateResponse = null;
    protected $userActivateResponse = null;
    protected $activationMailCreateResponse = null;
    protected $activationMailSendResponse = null;
    protected $userLoginResponse = null;

    public function __construct(ExceptionHelper $exception) {
        $this->roleRepository = new RoleRepository();
        $this->userRepository = new UserRepository();
        $this->userRoleRepository = new UserRoleRepository();
        $this->messageRepository = new MessageRepository();
        $this->activationMailRepository = new ActivationMailRepository;
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
        $this->roleRepository->add(new Role('Guest'));
        $this->roleRepository->add(new Role('User'));
        $this->roleRepository->add(new Role('Admin'));
    }

    /**
     * Method to create empty user 
     */
    public function newUser() {
        $this->user = new User(null, 'Guest', null, null);
    }

    /**
     * Methode to add a role to current user
     * @param String $name Rolename
     */
    public function addRole($name) {

        //Load guest role
        $role = $this->roleRepository->findByName($name);
        $userRole = new UserRole($this->user, $role);
        $this->user->addRole($userRole);
        $this->userRoleRepository->add($userRole);
        $this->userRepository->add($this->user);
    }

    /**
     * Method to create a DumpUsers, to simulate UserDatabase
     * @param array $data Userdata
     */
    public function createDumpUser(array $data) {

        foreach ($data as $row) {
            $user = new User($row['id'], $row['username'], $this->hasher->hash($row['password']), $row['email']);
            $role = $this->roleRepository->findByName('Guest');
            $userRole = new UserRole($user, $role);
            $user->addRole($userRole);
            $this->userRoleRepository->add($userRole);
            $this->userRepository->add($user);
        }
    }

    public function getUserRepository() {
        return $this->userRepository;
    }

    //Interactor tests
    /**
     * Method to create a user with an interactor
     * @param array $data Userdata
     */
    public function create(array $data) {
        foreach ($data as $row) {
            $useCreateRequest = new UserCreateRequest($row['username'], $row['password'], $row['email'], $row['password_confirm'], $row['email_confirm'], 'Guest');
        }


        $userCreateInteractor = new UserCreateInteractor(
                $this->userRepository, $this->roleRepository, $this->userRoleRepository, $this->hasher, $this->codeGenerator, $this->messageRepository
        );
        $activationMailCreateInteractor = new ActivationMailCreateInteractor($this->activationMailRepository);
        $activationMailSendInteractor = new ActivationMailSendInteractor($this->mailer);

        try {
            //create user account
            $this->userCreateResponse = $userCreateInteractor->invoke($useCreateRequest);
            
            //Create activation Mail
            $activationMailCreateRequest = new ActivationMailCreateRequest($this->userCreateResponse);
            $this->activationMailCreateResponse = $activationMailCreateInteractor->invoke($activationMailCreateRequest);
            //Modify and send Activation Mail
            $activationMailSendRequest = new ActivationMailSendRequest($this->activationMailCreateResponse);
            $this->activationMailSendResponse = $activationMailSendInteractor->invoke($activationMailSendRequest);
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
            $authInteractor = new UserAuthenticateInteractor($this->userRepository, $this->roleRepository, $this->userRoleRepository);

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
        assertTrue($this->activationMailSendResponse->getResult());
    }

    /**
     * Method to activate account and set a role for an active use with an interactor
     * @param array $data Userdata
     */
    public function activateAccount(array $data) {
        foreach ($data as $row) {
            $userActivateRequest = new UserActivateRequest($row['username'], $row['activation_code'], 'User');
        }
        $userActivateInteractor = new UserActivateInteractor($this->userRepository, $this->roleRepository, $this->userRoleRepository);
        try {
            $this->userActivateResponse = $userActivateInteractor->invoke($userActivateRequest);
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
        assertInstanceOf('\OpenTribes\Core\User\Create\Response', $this->userCreateResponse);
        assertNotNull($this->userCreateResponse->getUser());
    }

    /**
     * Assert an activation code mail was created with an interactor
     */
    public function assertHasActivationCode() {

        assertInstanceOf('\OpenTribes\Core\User\ActivationMail\Create\Response', $this->activationMailCreateResponse);
        assertNotNull($this->userCreateResponse->getUser()->getActivationCode());
    }

    /**
     * Assert account is activated
     */
    public function assertActivated() {
        assertNotNull($this->userActivateResponse);
        assertInstanceOf('\OpenTribes\Core\User\Activate\Response', $this->userActivateResponse);
        assertEmpty($this->userActivateResponse->getUser()->getActivationCode());
    }

    /**
     * Assert account has role
     * @param String $role Role
     */
    public function assertHasRole($role) {
        $user = $this->response->getUser();

        assertTrue($user->hasRole($role));
    }

}

?>
