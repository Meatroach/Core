<?php

namespace OpenTribes\Core\Test\UseCase;


use OpenTribes\Core\Entity\DirectionEntity;
use OpenTribes\Core\Mock\Repository\MockDirectionRepository;
use OpenTribes\Core\Mock\Request\MockListDirectionsRequest;
use OpenTribes\Core\Mock\Response\MockListDirectionsResponse;
use OpenTribes\Core\Test\BaseUseCaseTest;
use OpenTribes\Core\UseCase\ListDirectionsUseCase;

class ListDirectionsTest extends BaseUseCaseTest{

    public function testCanSeeDirections(){
        $directions = [];
        $directions[]=new DirectionEntity('none');
        $directionRepository = new MockDirectionRepository($directions);
        $request = new MockListDirectionsRequest();
        $response = new MockListDirectionsResponse();
        $useCase = new ListDirectionsUseCase($directionRepository);
        $useCase->process($request,$response);
        $this->assertNotEmpty($response->directions);
    }
    public function testCanSelectDirection(){
        $directions = [];
        $directions[]=new DirectionEntity('none');
        $directionRepository = new MockDirectionRepository($directions);
        $request = new MockListDirectionsRequest();
        $request->setDirection('none');
        $response = new MockListDirectionsResponse();
        $useCase = new ListDirectionsUseCase($directionRepository);
        $useCase->process($request,$response);
        $this->assertNotEmpty($response->directions);
        $this->assertTrue($response->directions[0]->isSelected);
    }
}