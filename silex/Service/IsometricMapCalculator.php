<?php

namespace OpenTribes\Core\Silex\Service;
use OpenTribes\Core\Service\MapCalculator;
/**
 * Description of IsometricMapCalculator
 *
 * @author BlackScorp<witalimik@web.de>
 */
class IsometricMapCalculator implements MapCalculator{
    private $width;
    private $height;
    public function __construct($height,$width) {
        ;
    }

    public function getArea($centerY, $centerX) {
        
    }

    public function pixelToPosition($top, $left) {
        
    }

    public function positionToPixel($y, $x) {
        
    }
    public function setTileHeight($height) {
        ;
    }
    public function setTileWidth($width) {
        ;
    }
}
