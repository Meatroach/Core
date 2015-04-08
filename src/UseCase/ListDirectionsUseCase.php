<?php
namespace OpenTribes\Core\UseCase;

use OpenTribes\Core\Repository\DirectionRepository;
use OpenTribes\Core\Request\ListDirectionsRequest;
use OpenTribes\Core\Response\ListDirectionsResponse;
use OpenTribes\Core\View\DirectionView;

class ListDirectionsUseCase {
    private $directionRepository;

    public function __construct(DirectionRepository $directionRepository)
    {
        $this->directionRepository = $directionRepository;
    }

    public function process(ListDirectionsRequest $request,ListDirectionsResponse $response){
        $directions = $this->directionRepository->findAll();
        foreach($directions as $direction){
            $directionView = new DirectionView($direction);
            if($request->getDirection() === $direction->getName()){
                $directionView->select();
            }
            $response->addDirection($directionView);
        }

    }
}