<?php

namespace OpenTribes\Core\Test\UseCase;


use OpenTribes\Core\Mock\Repository\MockUserRepository;
use OpenTribes\Core\Mock\Request\MockLoginRequest;
use OpenTribes\Core\Mock\Request\MockRegistrationRequest;
use OpenTribes\Core\Mock\Response\MockLoginResponse;
use OpenTribes\Core\Mock\Response\MockRegistrationResponse;
use OpenTribes\Core\Mock\Service\PlainHasher;
use OpenTribes\Core\Mock\Validator\MockLoginValidator;
use OpenTribes\Core\Mock\Validator\MockRegistrationValidator;
use OpenTribes\Core\UseCase\LoginUseCase;
use OpenTribes\Core\UseCase\RegistrationUseCase;

class LoginTest extends \PHPUnit_Framework_TestCase
{
    private $userRepository;
    private $loginValidator;
    private $passwordHasher;

    private function createDummyUser()
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
        $this->passwordHasher = new PlainHasher();
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

    public function failingData()
    {
        return array(
            'empty username' => array('', '123456', 'Invalid login'),
            'short username' => array('tes', '123456', 'Invalid login'),
            'long username' => array(str_repeat('s', 25), '123456', 'Invalid login'),
            'invalid username' => array('BläckScörp', '123456', 'Invalid login'),
            'empty password' => array('Test', '', 'Invalid login'),
            'short password' => array('Test', '12345', 'Invalid login'),
            'invalid login' => array('Test', 'testtest', 'Invalid login')
        );
    }

    public function testLoginSuccessful()
    {
        $username = 'Test';
        $password = '123456';
        $response = $this->executeUseCase($username, $password);

        $this->assertEmpty($response->getErrors());
    }

    /**
     * @dataProvider failingData
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
 