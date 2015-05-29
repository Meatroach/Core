<?php

namespace OpenTribes\Core\UseCase;

use DateTime;
use OpenTribes\Core\Repository\UserRepository;
use OpenTribes\Core\Request\RegistrationRequest;
use OpenTribes\Core\Response\RegistrationResponse;
use OpenTribes\Core\Service\PasswordHashService;
use OpenTribes\Core\Validator\RegistrationValidator;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;

class RegistrationUseCase implements LoggerAwareInterface{
    use LoggerAwareTrait;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var RegistrationValidator
     */
    private $validator;
    /**
     * @var PasswordHashService
     */
    private $passwordHashService;

    /**
     * @param UserRepository $userRepository
     * @param RegistrationValidator $validator
     * @param PasswordHashService $passwordHashService
     */
    public function __construct(
        UserRepository $userRepository,
        RegistrationValidator $validator,
        PasswordHashService $passwordHashService
    ) {
        $this->userRepository = $userRepository;
        $this->validator = $validator;
        $this->passwordHashService = $passwordHashService;
        $this->logger = new NullLogger();
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

    /**
     * @param RegistrationRequest $request
     * @param RegistrationResponse $response
     */
    public function process(RegistrationRequest $request, RegistrationResponse $response)
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
        $passwordHash = $this->passwordHashService->hash($request->getPassword());
        $user = $this->userRepository->create($userId, $request->getUsername(), $passwordHash, $request->getEmail());
        $user->setRegistrationDate(new DateTime());
        $this->userRepository->add($user);
    }
} 