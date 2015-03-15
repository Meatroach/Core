<?php

namespace OpenTribes\Core\UseCase;


use OpenTribes\Core\Repository\UserRepository;
use OpenTribes\Core\Request\LoginRequest;
use OpenTribes\Core\Request\Request;
use OpenTribes\Core\Response\LoginResponse;
use OpenTribes\Core\Response\Response;
use OpenTribes\Core\Service\PasswordHashService;
use OpenTribes\Core\Validator\LoginValidator;

class LoginUseCase implements UseCase{
    private $userRepository = null;
    private $passwordHasher = null;
    private $loginValidator = null;
    public function __construct(
        UserRepository $userRepository,
        LoginValidator $loginValidator,
        PasswordHashService $passwordHasher
    ) {
        $this->passwordHasher = $passwordHasher;
        $this->userRepository = $userRepository;
        $this->loginValidator = $loginValidator;
    }

    private function setValidatorValues(LoginRequest $request)
    {
        $this->loginValidator->username = $request->getUsername();
        $this->loginValidator->password = $request->getPassword();
        $user = $this->userRepository->findByUsername($request->getUsername());

        if ($user) {

            $this->loginValidator->verified = $this->passwordHasher->verify(
                $request->getPassword(),
                $user->getPasswordHash()
            );
        }
    }

    public function process(Request $request, Response $response)
    {
        $this->doProcess($request, $response);
    }

    /**
     * @param LoginResponse $response
     * @param LoginRequest  $request
     * @return void
     */
    private function doProcess(LoginRequest $request, LoginResponse $response)
    {
        $response->setLoginRequest($request);

        $this->setValidatorValues($request);

        if (!$this->loginValidator->isValid()) {
            $response->setErrors($this->loginValidator->getErrors());
            return;
        }
    }
} 