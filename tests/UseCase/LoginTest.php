<?php

namespace OpenTribes\Core\Test\UseCase;


use OpenTribes\Core\Test\Mock\Repository\MockUserRepository;
use OpenTribes\Core\Test\Mock\Request\MockLoginRequest;
use OpenTribes\Core\Test\Mock\Request\MockRegistrationRequest;
use OpenTribes\Core\Test\Mock\Response\MockLoginResponse;
use OpenTribes\Core\Test\Mock\Response\MockRegistrationResponse;
use OpenTribes\Core\Test\Mock\Service\PlainHashService;
use OpenTribes\Core\Test\Mock\Validator\MockLoginValidator;
use OpenTribes\Core\Test\Mock\Validator\MockRegistrationValidator;
use OpenTribes\Core\Test\BaseUseCaseTest;
use OpenTribes\Core\UseCase\LoginUseCase;
use OpenTribes\Core\UseCase\RegistrationUseCase;

class LoginTest extends BaseUseCaseTest
{
    private $loginValidator;
    private $passwordHasher;

    protected function createDummyUser()
    {
        $response = new MockRegistrationResponse();
        $request = new MockRegistrationRequest('Test', '123456', '123456', 'test@dummy.com','test@dummy.com');
        $request->acceptTerms();
        $userCase = new RegistrationUseCase(
            $this->userRepository,
            new MockRegistrationValidator(),
            $this->passwordHasher
        );
        $userCase->process($request, $response);
        return $response;
    }

    public function setUp()
    {
        $this->userRepository = new MockUserRepository();
        $this->loginValidator = new MockLoginValidator();
        $this->passwordHasher = new PlainHashService();
        $this->createDummyUser();
    }

    private function executeUseCase($username, $password)
    {
        $loginRequest = new MockLoginRequest($username, $password);
        $loginResponse = new MockLoginResponse();
        $loginUseCase = new LoginUseCase($this->userRepository, $this->loginValidator, $this->passwordHasher);
        $loginUseCase->process($loginRequest, $loginResponse);
        return $loginResponse;
    }



    public function testLoginSuccessful()
    {
        $username = 'Test';
        $password = '123456';
        $response = $this->executeUseCase($username, $password);

        $this->assertEmpty($response->getErrors());
    }

    /**
     * @dataProvider OpenTribes\Core\Test\DataProvider\LoginDataProvider::failingData
     * @param $username
     * @param $password
     * @param $expectedMessage
     */
    public function testLoginFailed($username, $password, $expectedMessage)
    {
        $response = $this->executeUseCase($username, $password);

        $this->assertTrue($response->hasErrors(), "LoginResponse has no errors");
        $this->assertContains($expectedMessage, $response->getErrors(),
            'Login Response not contains error : ' . $expectedMessage);
    }
}
 