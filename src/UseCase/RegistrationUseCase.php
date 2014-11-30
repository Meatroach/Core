<?php
namespace OpenTribes\Core\UseCase;

use OpenTribes\Core\Repository\UserRepository;
use OpenTribes\Core\Request\RegistrationRequest;
use OpenTribes\Core\Request\Request;
use OpenTribes\Core\Response\RegistrationResponse;
use OpenTribes\Core\Response\Response;
use OpenTribes\Core\Service\PasswordHasher;
use OpenTribes\Core\Validator\RegistrationValidator;

class RegistrationUseCase implements UseCase{

    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var RegistrationValidator
     */
    private $validator;
    /**
     * @var PasswordHasher
     */
    private $passwordHasher;

    /**
     * @param UserRepository $userRepository
     * @param RegistrationValidator $validator
     * @param PasswordHasher $passwordHasher
     */
    public function __construct(
        UserRepository $userRepository,
        RegistrationValidator $validator,
        PasswordHasher $passwordHasher
    ) {
        $this->userRepository = $userRepository;
        $this->validator = $validator;
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @param RegistrationRequest $request
     */
    private function setValidatorValues(RegistrationRequest $request)
    {
        $this->validator->username = $request->getUsername();
        $this->validator->password = $request->getPassword();
        $this->validator->passwordConfirm = $request->getPasswordConfirm();
        $this->validator->email = $request->getEmail();
        $this->validator->emailConfirm = $request->getEmailConfirm();
        $this->validator->acceptedTerms = $request->hasAcceptedTerms();
        $this->validator->usernameExists = (bool)$this->userRepository->findByUsername($request->getUsername());
        $this->validator->emailExists = (bool)$this->userRepository->findByEmail($request->getEmail());
    }

    public function process(Request $request, Response $response)
    {
        $this->doProcess($request, $response);
    }

    /**
     * @param  RegistrationResponse $response
     * @param  RegistrationRequest $request
     * @return void
     */
    private function doProcess(RegistrationRequest $request, RegistrationResponse $response)
    {
        $response->setRegistrationRequest($request);
        $this->setValidatorValues($request);

        if (!$this->validator->isValid()) {
            $response->setErrors($this->validator->getErrors());
            return;
        }
        $this->createUser($request);
    }

    /**
     * @param RegistrationRequest $request
     */
    private function createUser(RegistrationRequest $request)
    {
        $userId = $this->userRepository->getUniqueId();
        $passwordHash = $this->passwordHasher->hash($request->getPassword());
        $user = $this->userRepository->create($userId, $request->getUsername(), $passwordHash, $request->getEmail());
        $user->setRegistrationDate(new \DateTime());
        $this->userRepository->add($user);
    }
} 