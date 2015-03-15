<?php
namespace OpenTribes\Core\Test\UseCase;

use OpenTribes\Core\Mock\Repository\MockUserRepository;
use OpenTribes\Core\Mock\Request\MockRegistrationRequest;
use OpenTribes\Core\Mock\Response\MockRegistrationResponse;
use OpenTribes\Core\Mock\Service\PlainHashService;
use OpenTribes\Core\Mock\Validator\MockRegistrationValidator;
use OpenTribes\Core\Response\RegistrationResponse;
use OpenTribes\Core\UseCase\RegistrationUseCase;

class RegistrationTest extends \PHPUnit_Framework_TestCase {


    /**
     * @var MockUserRepository
     */
    protected $userRepository;
    protected $registrationValidator;
    protected $passwordHasher;
    public function setUp()
    {
        $this->userRepository = new MockUserRepository();
        $this->passwordHasher = new PlainHashService();
        $this->registrationValidator = new MockRegistrationValidator();
        $this->createDummyUser();
    }

    protected function createDummyUser()
    {
        $userId = $this->userRepository->getUniqueId();
        $user = $this->userRepository->create($userId, 'Dummy', '123456', 'dummy@test.com');
        $this->userRepository->add($user);
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
 