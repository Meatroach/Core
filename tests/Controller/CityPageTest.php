<?php

namespace OpenTribes\Core\Test\Controller;


use OpenTribes\Core\Test\SilexApplicationTest;
use Symfony\Component\HttpFoundation\Request;

class CityPageTest extends SilexApplicationTest
{
    public function testCanListCities(){
        $app = $this->getApplication();
        $request = Request::create('/cities');
        $response = $app->handle($request);
        $this->assertSame(200,$response->getStatusCode(),"Landing Page have another status code than 200");
    }
}