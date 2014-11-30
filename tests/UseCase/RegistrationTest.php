<?php
namespace OpenTribes\Core\Test\UseCase;

use OpenTribes\Core\Mock\Repository\MockUserRepository;
use OpenTribes\Core\Mock\Request\MockRegistrationRequest;
use OpenTribes\Core\Mock\Response\MockRegistrationResponse;
use OpenTribes\Core\Mock\Service\PlainHasher;
use OpenTribes\Core\Mock\Validator\MockRegistrationValidator;
use OpenTribes\Core\UseCase\RegistrationUseCase;

class RegistrationTest extends \PHPUnit_Framework_TestCase {
    public function testCanRegister(){
        $userRepository = new MockUserRepository();
        $registrationValidator = new MockRegistrationValidator();
        $passwordHasher = new PlainHasher();
        $request = new MockRegistrationRequest('Test','test@test.com','test@test.com','123456','123456',true);

        $response = new MockRegistrationResponse();
        $useCase = new RegistrationUseCase($userRepository,$registrationValidator,$passwordHasher);
        $useCase->process($request,$response);

        $this->assertFalse($response->hasErrors());
        $this->assertEmpty($response->getErrors());

    }
}
 