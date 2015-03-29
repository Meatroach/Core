<?php

namespace OpenTribes\Core\Test\UseCase;


use OpenTribes\Core\Entity\CityEntity;
use OpenTribes\Core\Entity\UserEntity;
use OpenTribes\Core\Mock\Repository\MockCityRepository;
use OpenTribes\Core\Mock\Repository\MockUserRepository;
use OpenTribes\Core\Mock\Request\MockListCitiesRequest;
use OpenTribes\Core\Mock\Response\MockListCitiesResponse;
use OpenTribes\Core\Repository\CityRepository;
use OpenTribes\Core\Test\BaseUseCaseTest;
use OpenTribes\Core\UseCase\ListCitiesUseCase;
use OpenTribes\Core\View\CityListView;

class ListCitiesTest extends BaseUseCaseTest
{
    /**
     * @var CityRepository
     */
    private $userCityRepository;
    public function setUp()
    {
        $this->userCityRepository = new MockCityRepository();
        $this->userRepository = new MockUserRepository();
    }
    private function createDummyCityForUser(UserEntity $user){
        $cities = [];
        $city = new CityEntity();
        $city->setOwner($user);
        $this->userCityRepository->add($city);
        $cities[]=$city;
        return $cities;
    }
    public function testCanListEmptyList()
    {
        $user = $this->createDummyUser();
        $response = $this->processUseCase($user->getUsername());
        $this->assertEmpty($response->getCities());
    }
    public function testCanListPlayersCities(){
        $user = $this->createDummyUser();
        $cities = $this->createDummyCityForUser($user);
        $expectedResult = [];
        foreach($cities as $city){
            $expectedResult[]=new CityListView($city);
        }
        $response = $this->processUseCase($user->getUsername());
        $this->assertEquals($expectedResult,$response->getCities());
    }
    /**
     * @param $username
     * @return MockListCitiesResponse
     */
    private function processUseCase($username)
    {
        $request = new MockListCitiesRequest($username);
        $response = new MockListCitiesResponse();
        $useCase = new ListCitiesUseCase($this->userCityRepository);
        $useCase->process($request, $response);
        return $response;
    }
}
