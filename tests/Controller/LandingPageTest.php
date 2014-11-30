<?php

namespace OpenTribes\Core\Test\Controller;


use Symfony\Component\HttpFoundation\Request;

class LandingPageTest extends SilexApplicationTest{
    public function testNoErrorsOnLandingPage(){

        $app = $this->getApplication();
        $request = Request::create('/');
        $response = $app->handle($request);
        $this->assertSame(200,$response->getStatusCode(),"Landing Page have another status code than 200");
    }
}
 