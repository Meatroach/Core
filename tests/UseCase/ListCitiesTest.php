<?php

namespace OpenTribes\Core\Test\UseCase;


use OpenTribes\Core\Mock\Request\MockListCitiesRequest;
use OpenTribes\Core\Mock\Response\MockListCitiesResponse;
use OpenTribes\Core\UseCase\ListCitiesUseCase;

class ListCitiesTest extends \PHPUnit_Framework_TestCase {
    public function testCanListEmptyList(){
        $request = new MockListCitiesRequest();
        $response = new MockListCitiesResponse();
        $useCase = new ListCitiesUseCase();
        $useCase->process($request,$response);
        $this->assertEmpty($response->getCities());
    }
}
