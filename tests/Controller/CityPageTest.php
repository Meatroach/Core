<?php

namespace OpenTribes\Core\Test\Controller;


use OpenTribes\Core\Entity\CityEntity;
use OpenTribes\Core\Entity\UserEntity;
use OpenTribes\Core\Repository\CityRepository;
use OpenTribes\Core\Silex\Repository;
use OpenTribes\Core\Test\SilexApplicationTest;
use Symfony\Component\HttpFoundation\Request;

class CityPageTest extends SilexApplicationTest
{
    public function testCanListCities(){
        $app = $this->getApplication();
        $app['session']->set('username','test');

        $city = new CityEntity();
        $city->setOwner(new UserEntity(1,'test','test','test@test.com'));

        /**
         * @var CityRepository $cityRepository
         */
        $cityRepository = $app[Repository::CITY];
        $cityRepository->add($city);

        $request = Request::create('/cities');

        $response = $app->handle($request);
        $this->assertSame(200,$response->getStatusCode());
    }
    public function testRedirectIfNotLoggedIn(){
        $app = $this->getApplication();
        $request = Request::create('/cities');
        $response = $app->handle($request);
        $this->assertSame(302,$response->getStatusCode());
        $this->assertTrue($response->isRedirect('/'));


    }
    public function testRedirectIfCitiesNotExists(){
        $app = $this->getApplication();
        $app['session']->set('username','test');
        $request = Request::create('/cities');
        $response = $app->handle($request);
        $this->assertSame(302,$response->getStatusCode());
        $this->assertTrue($response->isRedirect('/city/create'));
    }
}