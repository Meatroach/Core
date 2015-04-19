<?php

namespace OpenTribes\Core\Test\Controller;


use OpenTribes\Core\Repository\UserRepository;
use OpenTribes\Core\Service\PasswordHashService;
use OpenTribes\Core\Silex\Module;
use OpenTribes\Core\Silex\Repository;
use OpenTribes\Core\Silex\Response\MustacheResponse;
use OpenTribes\Core\Silex\Service;
use OpenTribes\Core\Test\SilexApplicationTest;
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
        $user = $userRepository->create($userId,'Test',$passwordHashService->hash('123456'),'test@test.com');
        $userRepository->add($user);
    }
    public function testRedirectIfLoggedIn(){
        $app = $this->getApplication();
        $app['session']->set('username','test');
        $request = Request::create('/');
        $response = $app->handle($request);
        $this->assertSame(302,$response->getStatusCode());
        $this->assertTrue($response->isRedirect('/cities'));
    }
    public function testLoginSuccessful(){
        $app = $this->getApplication();
        $this->createDummyUser($app[Repository::USER],$app[Service::PASSWORD_HASH]);
        $parameters = [
            'username' => 'Test',
            'password' => '123456'
        ];
        $request = Request::create('/account/login', 'POST', $parameters);
        /**
         * @var MustacheResponse $response
         */
        $response = $app->handle($request);
        $this->assertSame(302, $response->getStatusCode(), "Registration Page have another status code than 200");
        $this->assertSame($parameters['username'],$request->getSession()->get('username'));
    }
    /**
     * @dataProvider OpenTribes\Core\Test\DataProvider\LoginDataProvider::failingData
     * @param $username
     * @param $password
     * @param $expectedMessage
     */
    public function testLoginFailed($username,$password,$expectedMessage){
        $app = $this->getApplication();
        $parameters = [
            'username' => $username,
            'password' => $password
        ];
        $request = Request::create('/account/login', 'POST', $parameters);
        /**
         * @var MustacheResponse $response
         */
        $response = $app->handle($request);
        $this->assertContains($expectedMessage,$response->getContent());
    }

    /**
     * @expectedException \Exception
     */
    public function testConfigurationFolderNotExists(){
        $app = $this->getApplication();
        $app['env'] = 'invalid';
        $app->register(new Module());

    }
}
 