<?php

namespace OpenTribes\Core\Context\Player;

use OpenTribes\Core\Repository\MapTiles as MapTilesRepository;
use OpenTribes\Core\Repository\City as CityRepository;
use OpenTribes\Core\Request\ViewMap as ViewMapRequest;
use OpenTribes\Core\Response\ViewMap as ViewMapResponse;
use OpenTribes\Core\Service\MapCalculator;
use OpenTribes\Core\View\Tile as TileView;

/**
 * Description of ViewMap
 *
 * @author BlackScorp<witalimik@web.de>
 */
class ViewMap {

    private $mapTilesRepository;
    private $cityRepository;
    private $mapCalculator;

    public function __construct(MapTilesRepository $mapTilesRepository, CityRepository $cityRepository, MapCalculator $mapCalculator) {
        $this->mapTilesRepository = $mapTilesRepository;
        $this->cityRepository     = $cityRepository;
        $this->mapCalculator      = $mapCalculator;
    }

    public function process(ViewMapRequest $request, ViewMapResponse $response) {
        $y        = $request->getY();
        $x        = $request->getX();
        $username = $request->getUsername();
        $this->mapCalculator->setViewport($request->getViewportHeight(), $request->getViewportWidth());

        $response->width  = $request->getViewportWidth();
        $response->height = $request->getViewportHeight();

        if (!$y && !$x) {
            $city = $this->cityRepository->findMainByUsername($username);

            $x = $city->getX();
            $y = $city->getY();
        }


        $center         = $this->mapCalculator->positionToPixel($y, $x);
        $top            = $center['top'] - $request->getViewportHeight() / 2-64;
        $left           = $center['left'] - $request->getViewportWidth() / 2+64;
        $response->top  = -$center['top'] + $request->getViewportHeight() / 2;
        $response->left = -$center['left'] + $request->getViewportWidth() / 2-64;
        $area           = $this->mapCalculator->getArea($top, $left);
        foreach ($area as $tile) {
            $y                 = $tile['y'];
            $x                 = $tile['x'];
            $position          = $this->mapCalculator->positionToPixel($y, $x);
            $left              = $position['left'];
            $top               = $position['top'];
            $response->tiles[] = array(
                'name'   => 'gras',
                'x'      => $x,
                'y'      => $y,
                'top'    => $top,
                'left'   => $left,
                'width'  => 128,
                'height' => 64
            );
        }
    }

}
