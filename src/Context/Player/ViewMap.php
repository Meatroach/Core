<?php

namespace OpenTribes\Core\Context\Player;

use OpenTribes\Core\Repository\City as CityRepository;
use OpenTribes\Core\Repository\MapTiles as MapTilesRepository;
use OpenTribes\Core\Request\ViewMap as ViewMapRequest;
use OpenTribes\Core\Response\ViewMap as ViewMapResponse;
use OpenTribes\Core\Service\MapCalculator;
use OpenTribes\Core\View\City as CityView;
use OpenTribes\Core\View\Tile as TileView;

/**
 * Description of ViewMap
 *
 * @author BlackScorp<witalimik@web.de>
 */
class ViewMap
{

    private $mapTilesRepository;
    private $cityRepository;
    private $mapCalculator;

    public function __construct(
        MapTilesRepository $mapTilesRepository,
        CityRepository $cityRepository,
        MapCalculator $mapCalculator
    ) {
        $this->mapTilesRepository = $mapTilesRepository;
        $this->cityRepository = $cityRepository;
        $this->mapCalculator = $mapCalculator;
    }

    public function process(ViewMapRequest $request, ViewMapResponse $response)
    {
        $posY = $request->getPosY();
        $posX = $request->getPosX();
        $username = $request->getUsername();
        $this->mapCalculator->setViewport($request->getViewportHeight(), $request->getViewportWidth());

        $response->width = $request->getViewportWidth();
        $response->height = $request->getViewportHeight();
        $defaultTile = $this->mapTilesRepository->getDefaultTile();
        $city = $this->cityRepository->findSelectedByUsername($username);
        $step = 1;
        if (!$posY && !$posX) {
            $posX = $city->getPosX();
            $posY = $city->getPosY();
        }

        $response->downX = $posX + $step;
        $response->downY = $posY + $step;
        $response->upX = $posX - $step;
        $response->upY = $posY - $step;
        $response->rightX = $posX + $step;
        $response->rightY = $posY - $step;
        $response->leftX = $posX - $step;
        $response->leftY = $posY + $step;
        $center = $this->mapCalculator->positionToPixel($posY, $posX);

        $top = $center['top'] - $request->getViewportHeight() / 2;
        $left = $center['left'] - $request->getViewportWidth() / 2;
        $response->top = -$center['top'] + $request->getViewportHeight() / 2 - $defaultTile->getHeight() / 2;
        $response->left = -$center['left'] + $request->getViewportWidth() / 2 - $defaultTile->getWidth() / 2;
        $area = $this->mapCalculator->getArea($top, $left);


        $cities = $this->cityRepository->findAllInArea($area);

        foreach ($cities as $city) {
            $posY = $city->getPosY();
            $posX = $city->getPosX();
            $position = $this->mapCalculator->positionToPixel($posY, $posX);
            $left = $position['left'];
            $top = $position['top'];
            $cityView = new CityView($city);
            $cityView->top = $top;
            $cityView->left = $left;
            $cityView->height = $defaultTile->getHeight();
            $cityView->width = $defaultTile->getWidth();
            $cityView->layerZ = $posY + $posX * 2;
            $cityView->level = 1;
            $response->cities[] = $cityView;

        }

        $map = $this->mapTilesRepository->findAllInArea($area);
        foreach ($area as $location) {
            $posX = $location['posX'];
            $posY = $location['posY'];
            $tile = $map->getTile($posY, $posX);
            if (!$tile) {
                $tile = $defaultTile;
            }
            $position = $this->mapCalculator->positionToPixel($posY, $posX);
            $left = $position['left'];
            $top = $position['top'];
            $tileView = new TileView($tile);
            $tileView->top = $top;
            $tileView->posX = $posX;
            $tileView->posY = $posY;
            $tileView->layerZ = $posY + $posX;
            $tileView->left = $left;
            $response->tiles[] = $tileView;
        }
        return true;
    }
}
