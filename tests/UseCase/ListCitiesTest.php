<?php

namespace OpenTribes\Core\Test\UseCase;


use OpenTribes\Core\Mock\Repository\MockUserRepository;
use OpenTribes\Core\Mock\Request\MockListCitiesRequest;
use OpenTribes\Core\Mock\Response\MockListCitiesResponse;
use OpenTribes\Core\Test\BaseUseCaseTest;
use OpenTribes\Core\UseCase\ListCitiesUseCase;

class ListCitiesTest extends BaseUseCaseTest
{
    public function setUp()
    {
        $this->userRepository = new MockUserRepository();
    }

    public function testCanListEmptyList()
    {
        $response = $this->processUseCase();
        $this->assertEmpty($response->getCities());
    }

    public function testCanListUsersCities()
    {
        $user = $this->createDummyUser();
    }

    /**
     * @return MockListCitiesResponse
     */
    private function processUseCase()
    {
        $request = new MockListCitiesRequest();
        $response = new MockListCitiesResponse();
        $useCase = new ListCitiesUseCase();
        $useCase->process($request, $response);
        return $response;
    }
}
