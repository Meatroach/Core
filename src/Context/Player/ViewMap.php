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
        $y                = $request->getY();
        $x                = $request->getX();
        $username         = $request->getUsername();
        $response->width  = $request->getWidth();
        $response->height = $request->getHeight();
        $defaultTile      = $this->mapTilesRepository->getDefaultTile();
        if (!$y && !$x) {
            $city = $this->cityRepository->findMainByUsername($username);

            $x = $city->getX();
            $y = $city->getY();
        }
        $this->mapCalculator->setTileHeight($defaultTile->getHeight());
        $this->mapCalculator->setTileWidth($defaultTile->getWidth());
        $area = $this->mapCalculator->getArea($y, $x);
    }

}
