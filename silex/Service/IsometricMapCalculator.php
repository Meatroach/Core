<?php

namespace OpenTribes\Core\Silex\Service;

use OpenTribes\Core\Service\MapCalculator;

/**
 * Description of IsometricMapCalculator
 *
 * @author BlackScorp<witalimik@web.de>
 */
class IsometricMapCalculator implements MapCalculator
{

    private $width;
    private $height;
    private $tileWidth;
    private $tileHeight;
    private $viewPortWidth;
    private $viewPortHeight;
    private $originX;
    private $originY;
    private $tileRatio;

    public function __construct($height, $width, $viewPortHeight, $viewPortWidth, $tileHeight, $tileWidth)
    {
        $this->width = $width;
        $this->height = $height;
        $this->viewPortHeight = $viewPortHeight;
        $this->viewPortWidth = $viewPortWidth;
        $this->tileHeight = $tileHeight;
        $this->tileWidth = $tileWidth;
        $this->calculateOrigin();
        $this->calculateTileRatio();
    }

    private function calculateOrigin()
    {
        $this->originX = $this->height * $this->tileWidth / 2;
        $this->originY = 0;
    }

    private function calculateTileRatio()
    {
        $this->tileRatio = $this->tileWidth / $this->tileHeight;
    }

    public function getArea($top, $left)
    {
        $halfTileWidth = $this->tileWidth / 2;
        $halfTileHeight = $this->tileHeight / 2;

        $halfViewportWidth = round($this->viewPortWidth/2);
        $halfViewportHeight = round($this->viewPortHeight/2);
        $topPosition = $top-$halfViewportHeight;
        $bottomPosition = $top+$halfViewportHeight;
        $leftPosition =$left-$halfViewportWidth;
        $rightPosition = $left+$halfViewportWidth;
        $area = array();
        for ($y = $topPosition; $y < $bottomPosition; $y +=$halfTileHeight) {
            for ($x = $leftPosition; $x < $rightPosition; $x +=$halfTileWidth) {
                $row = $this->pixelToPosition($y, $x);
                $positionX = max(0, min($this->width, $row['posX']));
                $positionY = max(0, min($this->height, $row['posY']));
                $key = sprintf("%d-%d", $positionY, $positionX);
                $area[$key] = array('posY' => $positionY, 'posX' => $positionX);
            }
        }
        return $area;
    }

    public function pixelToPosition($top, $left)
    {
        $newLeft = ($left - $this->originX) / $this->tileRatio;
        $posX = round(($top + $newLeft) / $this->tileHeight);
        $posY = round(($top - $newLeft) / $this->tileHeight);
        return array(
            'posX' => $posX,
            'posY' => $posY
        );
    }

    public function positionToPixel($posY, $posX)
    {

        $left = round(($posX - $posY) * ($this->tileWidth / 2) + $this->originX);
        $top = round(($posX + $posY) * ($this->tileHeight / 2));
        return array(
            'top' => $top,
            'left' => $left
        );
    }

    public function setViewport($height, $width)
    {
        $this->viewPortWidth = $width;
        $this->viewPortHeight = $height;
    }


    public function getCenterPosition($posY, $posX)
    {
        $position = $this->positionToPixel($posY, $posX);
        $left = $position['left'];
        $top = $position['top'];
        $posX = -$left + $this->viewPortWidth / 2 - $this->tileWidth / 2;
        $posY = -$top + $this->viewPortHeight / 2;
        return array(
            'top' => $posY,
            'left' => $posX
        );
    }

    public function getNeighborLocations($posY, $posX, $range = 1)
    {

    }

}
