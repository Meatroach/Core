<?php

namespace OpenTribes\Core\UseCase;


use OpenTribes\Core\Repository\UserRepository;
use OpenTribes\Core\Request\LoginRequest;
use OpenTribes\Core\Response\LoginResponse;
use OpenTribes\Core\Service\PasswordHashService;
use OpenTribes\Core\Validator\LoginValidator;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;

class LoginUseCase implements LoggerAwareInterface{
    use LoggerAwareTrait;
    private $userRepository = null;
    private $passwordHashService = null;
    private $loginValidator = null;
    public function __construct(
        UserRepository $userRepository,
        LoginValidator $loginValidator,
        PasswordHashService $passwordHashService
    ) {
        $this->passwordHashService = $passwordHashService;
        $this->userRepository = $userRepository;
        $this->loginValidator = $loginValidator;
        $this->logger = new NullLogger();
    }

    private function setValidatorValues(LoginRequest $request)
    {
        $this->loginValidator->username = $request->getUsername();
        $this->loginValidator->password = $request->getPassword();
        $user = $this->userRepository->findByUsername($request->getUsername());

        if ($user) {
            $this->loginValidator->verified = $this->passwordHashService->verify(
                $request->getPassword(),
                $user->getPasswordHash()
            );
        }
    }

    /**
     * @param LoginRequest $request
     * @param LoginResponse $response
     */
    public function process(LoginRequest $request, LoginResponse $response)
    {
        $response->setLoginRequest($request);

        $this->setValidatorValues($request);

        if (!$this->loginValidator->isValid()) {
            $response->setErrors($this->loginValidator->getErrors());
            return;
        }
    }
} 