<?php

namespace OpenTribes\Core\Test\Controller;


use Symfony\Component\HttpFoundation\Request;

class LandingPageTest extends SilexApplicationTest{
    public function testNoErrorsOnLandingPage(){
        $request = Request::create('/');
        $app = $this->getApplication();
        $response = $app->handle($request);
        $this->assertSame(200,$response->getStatusCode(),"Landing Page have another status code than 200");

    }
}
 