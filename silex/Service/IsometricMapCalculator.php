<?php

namespace OpenTribes\Core\Silex\Service;

use OpenTribes\Core\Service\MapCalculator;

/**
 * Description of IsometricMapCalculator
 *
 * @author BlackScorp<witalimik@web.de>
 */
class IsometricMapCalculator implements MapCalculator {

    private $width;
    private $height;
    private $tileWidth;
    private $tileHeight;
    private $viewPortWidth;
    private $viewPortHeight;
    private $originX;
    private $originY;
    private $tileRatio;

    public function __construct($height, $width, $viewPortHeight, $viewPortWidth, $tileHeight, $tileWidth) {
        $this->width          = $width;
        $this->height         = $height;
        $this->viewPortHeight = $viewPortHeight;
        $this->viewPortWidth  = $viewPortWidth;
        $this->tileHeight     = $tileHeight;
        $this->tileWidth      = $tileWidth;
        $this->calculateOrigin();
        $this->calculateTileRatio();
    }

    private function calculateOrigin() {
        $this->originX = $this->height * $this->tileWidth / 2;
        $this->originY = 0;
    }

    private function calculateTileRatio() {
        $this->tileRatio = $this->tileWidth / $this->tileHeight;
    }

    public function getArea($top, $left) {


        $start  = array(
            'x' => $left - $this->tileWidth / 2,
            'y' => $top + $this->tileHeight /2
        );
        $end    = array(
            'x' => $start['x'] + $this->viewPortWidth + $this->tileWidth,
            'y' => $start['y'] + $this->viewPortHeight + $this->tileHeight/2
        );
        $width  = $this->width * $this->tileWidth;
        $height = $this->height * $this->tileHeight;
        $area   = array();
        for ($y = $start['y']; $y <= $end['y']; $y+=$this->tileHeight / 2) {
            for ($x = $start['x']; $x <= $end['x']; $x+=$this->tileWidth / 2) {
                $row        = $this->pixelToPosition($y, $x);
                $positionX  = max(0, min($width, $row['x']));
                $positionY  = max(0, min($height, $row['y']));
                $key        = sprintf("%d-%d", $positionY, $positionX);
                $area[$key] = array('y' => $positionY, 'x' => $positionX);
            }
        }
        return $area;
    }

    public function pixelToPosition($top, $left) {
        $newLeft = ($left - $this->originX) / $this->tileRatio;
        $x       = ~~(($top + $newLeft) / $this->tileHeight);
        $y       = ~~(($top - $newLeft) / $this->tileHeight);
        return array(
            'x' => $x,
            'y' => $y
        );
    }

    public function setViewport($height, $width) {
        $this->viewPortWidth  = $width;
        $this->viewPortHeight = $height;
    }

    public function positionToPixel($y, $x) {
        $left = ~~(($x - $y) * $this->tileWidth / 2 + $this->originX);
        $top  = ~~(($x + $y) * $this->tileHeight / 2);
        return array(
            'top'  => $top,
            'left' => $left
        );
    }

    public function getCenterPosition($y, $x) {
        $position = $this->positionToPixel($y, $x);
        $left     = $position['left'];
        $top      = $position['top'];
        $x        = -$left + $this->viewPortWidth / 2 - $this->tileWidth / 2;
        $y        = -$top + $this->viewPortHeight / 2;
        return array(
            'top'  => $y,
            'left' => $x
        );
    }

}
