<?php

namespace OpenTribes\Core\Interactor;
use OpenTribes\Core\Request\SelectLocation as SelectLocationRequest;
use OpenTribes\Core\Response\SelectLocation as SelectLocationResponse;
use OpenTribes\Core\Service\LocationCalculator;
use OpenTribes\Core\Value\Direction;
/**
 * Interactor to calculate map location for given direction
 *
 * @author BlackScorp<witalimik@web.de>
 */
class SelectLocation {

    /**
     * @var LocationCalculator
     */
    private $locationCalculator;
    public function __construct(LocationCalculator $locationCalulator) {
        $this->locationCalculator = $locationCalulator;
    }

    /**
     * @param \OpenTribes\Core\Request\SelectLocation $request
     * @param \OpenTribes\Core\Response\SelectLocation $response
     */
    public function process(SelectLocationRequest $request,SelectLocationResponse $response){
        $direction = new Direction($request->getDirection());
        $this->locationCalculator->calculate($direction);
        $response->x = $this->locationCalculator->getX();
        $response->y = $this->locationCalculator->getY();
    }
}
