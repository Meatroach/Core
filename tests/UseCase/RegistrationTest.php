<?php
namespace OpenTribes\Core\Test\UseCase;

use OpenTribes\Core\Test\Mock\Repository\MockUserRepository;
use OpenTribes\Core\Test\Mock\Request\MockRegistrationRequest;
use OpenTribes\Core\Test\Mock\Response\MockRegistrationResponse;
use OpenTribes\Core\Test\Mock\Service\PlainHashService;
use OpenTribes\Core\Test\Mock\Validator\MockRegistrationValidator;
use OpenTribes\Core\Response\RegistrationResponse;
use OpenTribes\Core\Test\BaseUseCaseTest;
use OpenTribes\Core\UseCase\RegistrationUseCase;

class RegistrationTest extends BaseUseCaseTest {


    protected $registrationValidator;
    protected $passwordHasher;
    public function setUp()
    {
        $this->userRepository = new MockUserRepository();
        $this->passwordHasher = new PlainHashService();
        $this->registrationValidator = new MockRegistrationValidator();
        $this->createDummyUser();
    }

    /**
     * @param $username
     * @param $password
     * @param $passwordConfirm
     * @param $email
     * @param $emailConfirm
     * @param $acceptedTerms
     * @return RegistrationResponse
     */
    private function processUseCase(
        $username,
        $password,
        $passwordConfirm,
        $email,
        $emailConfirm,
        $acceptedTerms = false
    ) {
        $registrationRequest = new MockRegistrationRequest(
            $username,
            $password,
            $passwordConfirm,
            $email,
            $emailConfirm
        );
        if ($acceptedTerms) {
            $registrationRequest->acceptTerms();
        }
        $registrationUseCase = new RegistrationUseCase(
            $this->userRepository,
            $this->registrationValidator,
            $this->passwordHasher
        );
        $registrationResponse = new MockRegistrationResponse();
        $registrationUseCase->process($registrationRequest, $registrationResponse);

        return $registrationResponse;
    }



    public function testRegistrationSuccess()
    {
        $username = 'Username';
        $password = '123456';
        $passwordConfirm = '123456';
        $email = 'test@foo.bar';
        $emailConfirm = 'test@foo.bar';
        $acceptedTerms = true;
        $response = $this->processUseCase(
            $username,
            $password,
            $passwordConfirm,
            $email,
            $emailConfirm,
            $acceptedTerms
        );
        $this->assertEmpty($response->getErrors());
    }


    /**
     * @dataProvider OpenTribes\Core\Test\DataProvider\RegistrationDataProvider::failingData
     * @param $username
     * @param $password
     * @param $passwordConfirm
     * @param $email
     * @param $emailConfirm
     * @param $acceptedTerms
     * @param $expectedMessage
     */
    public function testRegistrationFailed($username, $password, $passwordConfirm, $email, $emailConfirm, $acceptedTerms, $expectedMessage)
    {
        $response = $this->processUseCase(
            $username,
            $password,
            $passwordConfirm,
            $email,
            $emailConfirm,
            $acceptedTerms
        );


        $this->assertContains($expectedMessage, $response->getErrors());
    }
}
 