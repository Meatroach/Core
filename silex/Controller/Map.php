<?php

namespace OpenTribes\Core\Silex\Controller;

use OpenTribes\Core\Repository\MapTiles as MapTilesRepository;
use OpenTribes\Core\Repository\City as CityRepository;
use Symfony\Component\HttpFoundation\Request;
use OpenTribes\Core\Service\MapCalculator;
use OpenTribes\Core\Context\Player\ViewMap as ViewMapContext;
use OpenTribes\Core\Request\ViewMap as ViewMapRequest;
use OpenTribes\Core\Response\ViewMap as ViewMapResponse;

/**
 * Description of Map
 *
 * @author BlackScorp<witalimik@web.de>
 */
class Map {

    private $mapTilesRepository;
    private $cityRepository;
    private $mapCalculator;

    public function __construct(MapTilesRepository $mapTilesRepository, CityRepository $cityRepository, MapCalculator $mapCalculator) {
        $this->mapTilesRepository = $mapTilesRepository;
        $this->cityRepository     = $cityRepository;
        $this->mapCalculator      = $mapCalculator;
    }

    public function viewAction(Request $httpRequest) {
        $y                = $httpRequest->get('y');
        $x                = $httpRequest->get('x');
        $username         = $httpRequest->getSession()->get('username');
        
        $width            = $httpRequest->get('width');
        $height           = $httpRequest->get('height');
        $request          = new ViewMapRequest($y, $x, $username, $height, $width);
        $response         = new ViewMapResponse;
        $context          = new ViewMapContext($this->mapTilesRepository, $this->cityRepository, $this->mapCalculator);
        $response->failed = $context->process($request, $response);
        return $response;
    }

}
