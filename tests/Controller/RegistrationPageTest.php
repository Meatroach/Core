<?php

namespace OpenTribes\Core\Test\Controller;


use OpenTribes\Core\Repository\UserRepository;
use OpenTribes\Core\Silex\Repository;
use OpenTribes\Core\Silex\Response\AccountResponse;
use OpenTribes\Core\Silex\Response\MustacheResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RegistrationPageTest extends SilexApplicationTest
{


    protected function createDummyUser(UserRepository $userRepository)
    {
        $userId = $userRepository->getUniqueId();
        $user = $userRepository->create($userId, 'Dummy', '123456', 'dummy@test.com');
        $userRepository->add($user);
    }
    public function testCanSeeRegistrationPage()
    {
        $app = $this->getApplication();
        $request = Request::create('/account/create');
        /**
         * @var Response $response
         */
        $response = $app->handle($request);
        $this->assertSame(200, $response->getStatusCode(), "Registration Page have another status code than 200");
    }

    public function testRegistrationIsSuccessful()
    {
        $app = $this->getApplication();
        $parameters = [
            'username' => 'test',
            'password' => '123456',
            'passwordConfirm' => '123456',
            'email' => 'test@test.com',
            'emailConfirm' => 'test@test.com',
            'termsAndConditions' => 'On'
        ];
        $request = Request::create('/account/create', 'POST', $parameters);
        /**
         * @var MustacheResponse $response
         */
        $response = $app->handle($request);
        $this->assertSame(302, $response->getStatusCode(), "Registration Page have another status code than 200");
    }

    /**
     * @dataProvider OpenTribes\Core\Test\DataProvider\RegistrationDataProvider::failingData
     */
    public function testRegistrationFailed($username, $password, $passwordConfirm, $email, $emailConfirm, $acceptedTerms, $expectedMessage){
        $app = $this->getApplication();

        $this->createDummyUser($app[Repository::USER]);
        $parameters = [
            'username' => $username,
            'password' => $password,
            'passwordConfirm' => $passwordConfirm,
            'email' => $email,
            'emailConfirm' => $emailConfirm,
            'termsAndConditions' => $acceptedTerms?'On':''
        ];
        $request = Request::create('/account/create', 'POST', $parameters);
        /**
         * @var Response $response;
         */
        $response = $app->handle($request);
        $this->assertSame(200, $response->getStatusCode(), "Registration Page have another status code than 200");
        $this->assertContains($expectedMessage,$response->getContent());
    }
} 