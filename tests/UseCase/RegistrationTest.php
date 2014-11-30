<?php
namespace OpenTribes\Core\Test\UseCase;

use OpenTribes\Core\Mock\Repository\MockUserRepository;
use OpenTribes\Core\Mock\Request\MockRegistrationRequest;
use OpenTribes\Core\Mock\Response\MockRegistrationResponse;
use OpenTribes\Core\Mock\Service\PlainHasher;
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
        $this->passwordHasher = new PlainHasher();
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

    public function failingData()
    {
        return array(
            'short username'=>array('Us','123456','123456','test@foo.bar','test@foo.bar',true,'Username is too short'),
            'long username'=>array(str_repeat('u', 25),'123456','123456','test@foo.bar','test@foo.bar',true,'Username is too long'),
            'invalid username'=>array('BläckScörp','123456','123456','test@foo.bar','test@foo.bar',true,'Username contains invalid character'),
            'empty username'=> array('','123456','123456','test@foo.bar','test@foo.bar',true,'Username is empty'),
            'username exists'=>array('Dummy','123456','123456','test@foo.bar','test@foo.bar',true,'Username exists'),
            'password too short'=>array('BlackScorp','123','123456','test@foo.bar','test@foo.bar',true,'Password is too short'),
            'password confirm not match'=>array('BlackScorp','123456','654321','test@foo.bar','test@foo.bar',true,'Password confirm not match'),
            'password is empty'=>array('BlackScorp','','','test@foo.bar','test@foo.bar',true,'Password is empty'),
            'empty email'=>array('BlackScorp','123456','123456','','',true,'Email is empty'),
            'invalid email'=>array('BlackScorp','123456','123456','test@foo','test@foo',true,'Email is invalid'),
            'email confirm not match'=>array('BlackScorp','123456','123456','test@foo.bar','test@foo',true,'Email confirm not match'),
            'email exists'=>array('BlackScorp','123456','123456','dummy@test.com','dummy@test.com',true,'Email exists'),
            'accept terms'=>array('BlackScorp','123456','123456','test@foo.bar','test@foo.bar',false,'Terms and Conditions are not accepted'),
        );
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
     * @dataProvider failingData
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
 