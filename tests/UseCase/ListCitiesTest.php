<?php

namespace OpenTribes\Core\Test\UseCase;


use OpenTribes\Core\Mock\Repository\MockUserCityRepository;
use OpenTribes\Core\Mock\Repository\MockUserRepository;
use OpenTribes\Core\Mock\Request\MockListCitiesRequest;
use OpenTribes\Core\Mock\Response\MockListCitiesResponse;
use OpenTribes\Core\Test\BaseUseCaseTest;
use OpenTribes\Core\UseCase\ListCitiesUseCase;

class ListCitiesTest extends BaseUseCaseTest
{
    private $userCityRepository;
    public function setUp()
    {
        $this->userCityRepository = new MockUserCityRepository();
        $this->userRepository = new MockUserRepository();
    }

    public function testCanListEmptyList()
    {
        $user = $this->createDummyUser();
        $response = $this->processUseCase($user->getUsername());
        $this->assertEmpty($response->getCities());
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
