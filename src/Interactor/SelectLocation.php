<?php

namespace OpenTribes\Core\Interactor;
use OpenTribes\Core\Request\SelectLocation as SelectLocationRequest;
use OpenTribes\Core\Response\SelectLocation as SelectLocationResponse;
use OpenTribes\Core\Service\LocationCalculator;
use OpenTribes\Core\Value\Direction;
/**
 * Description of SelectLocation
 *
 * @author BlackScorp<witalimik@web.de>
 */
class SelectLocation {
    private $locationCalculator;
    public function __construct(LocationCalculator $locationCalulator) {
        $this->locationCalculator = $locationCalulator;
    }
    public function process(SelectLocationRequest $request,SelectLocationResponse $response){
        $direction = new Direction($request->getDirection());
        $this->locationCalculator->calculate($direction);
        $response->x = $this->locationCalculator->getX();
        $response->y = $this->locationCalculator->getY();
    }
}
