<?php

namespace OpenTribes\Core\Context\Player;

use OpenTribes\Core\Repository\MapTiles as MapTilesRepository;
use OpenTribes\Core\Repository\City as CityRepository;
use OpenTribes\Core\Request\ViewMap as ViewMapRequest;
use OpenTribes\Core\Response\ViewMap as ViewMapResponse;
use OpenTribes\Core\Service\MapCalculator;
use OpenTribes\Core\View\Tile as TileView;
use OpenTribes\Core\View\City as CityView;

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
        $defaultTile      = $this->mapTilesRepository->getDefaultTile();
        $city             = $this->cityRepository->findMainByUsername($username);
        $step             = 1;
        if (!$y && !$x) {
            $x = $city->getX();
            $y = $city->getY();
        }

        $response->downX  = $x + $step;
        $response->downY  = $y + $step;
        $response->upX    = $x - $step;
        $response->upY    = $y - $step;
        $response->rightX = $x + $step;
        $response->rightY = $y - $step;
        $response->leftX  = $x - $step;
        $response->leftY  = $y + $step;
        $center           = $this->mapCalculator->positionToPixel($y, $x);

        $top            = $center['top'] - $request->getViewportHeight() / 2;
        $left           = $center['left'] - $request->getViewportWidth() / 2;
        $response->top  = -$center['top'] + $request->getViewportHeight() / 2 - $defaultTile->getHeight() / 2;
        $response->left = -$center['left'] + $request->getViewportWidth() / 2 - $defaultTile->getWidth() /2;
        $area           = $this->mapCalculator->getArea($top, $left);

        $position = $this->mapCalculator->positionToPixel($city->getY(), $city->getX());
        $cities   = $this->cityRepository->findAllInArea($area);

        foreach ($cities as $city) {
            $y                  = $city->getY();
            $x                  = $city->getX();
            $position           = $this->mapCalculator->positionToPixel($y, $x);
            $left               = $position['left'];
            $top                = $position['top'];
            $cityView           = new CityView($city);
            $cityView->top      = $top;
            $cityView->left     = $left;
            $cityView->height   = $defaultTile->getHeight();
            $cityView->width    = $defaultTile->getWidth();
            $cityView->z        = $y + $x * 2;
            $cityView->level  = 1;
            $response->cities[] = $cityView;
        }

        $map = $this->mapTilesRepository->findAllInArea($area);
        foreach ($area as $location) {
            $x    = $location['x'];
            $y    = $location['y'];
            $tile = $map->getTile($y, $x);
            if (!$tile) {
                $tile = $defaultTile;
            }
            $position          = $this->mapCalculator->positionToPixel($y, $x);
            $left              = $position['left'];
            $top               = $position['top'];
            $tileView          = new TileView($tile);
            $tileView->top     = $top;
            $tileView->x       = $x;
            $tileView->y       = $y;
            $tileView->z       = $y + $x;
            $tileView->left    = $left;
            $response->tiles[] = $tileView;
        }
    }

}
