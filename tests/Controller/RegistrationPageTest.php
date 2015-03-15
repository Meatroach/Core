<?php

namespace OpenTribes\Core\Test\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RegistrationPageTest extends SilexApplicationTest
{
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

    public function testRegistrationIsSuccessfull()
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
         * @var Response $response
         */
        $response = $app->handle($request);
        $this->assertSame(200, $response->getStatusCode(), "Registration Page have another status code than 200");
    }

    /**
     * @dataProvider OpenTribes\Core\Test\DataProvider\RegistrationDataProvider::failingData
     */
    public function testRegistrationFailed($username, $password, $passwordConfirm, $email, $emailConfirm, $acceptedTerms, $expectedMessage){
        $app = $this->getApplication();
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