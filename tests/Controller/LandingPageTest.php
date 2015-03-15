<?php

namespace OpenTribes\Core\Test\Controller;


use OpenTribes\Core\Repository\UserRepository;
use OpenTribes\Core\Service\PasswordHashService;
use OpenTribes\Core\Silex\Repository;
use OpenTribes\Core\Silex\Response\IndexResponse;
use OpenTribes\Core\Silex\Response\MustacheResponse;
use OpenTribes\Core\Silex\Service;
use Symfony\Component\HttpFoundation\Request;

class LandingPageTest extends SilexApplicationTest{
    public function testNoErrorsOnLandingPage(){

        $app = $this->getApplication();
        $request = Request::create('/');
        $response = $app->handle($request);
        $this->assertSame(200,$response->getStatusCode(),"Landing Page have another status code than 200");
    }
    private function createDummyUser(UserRepository $userRepository,PasswordHashService $passwordHashService){
        $userId = $userRepository->getUniqueId();
        $user = $userRepository->create($userId,'Test',$passwordHashService->hash('test'),'test@test.com');
        $userRepository->add($user);
    }
    public function testLoginSuccessful(){
        $app = $this->getApplication();
        $this->createDummyUser($app[Repository::USER],$app[Service::PASSWORD_HASH]);
        $parameters = [
            'username' => 'Test',
            'password' => 'test'
        ];
        $request = Request::create('/account/login', 'POST', $parameters);
        /**
         * @var MustacheResponse $response
         */
        $response = $app->handle($request);
        $this->assertSame(200, $response->getStatusCode(), "Registration Page have another status code than 200");
        /**
         * @var IndexResponse $rawResponse;
         */
        $rawResponse = $response->getRawResponse();
        $this->assertFalse($rawResponse->hasErrors(),"Login failed");
    }
}
 