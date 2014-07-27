<?php
/**
 * Created by PhpStorm.
 * User: BlackScorp
 * Date: 18.06.14
 * Time: 20:37
 */

namespace OpenTribes\Core\Silex\Service;


use OpenTribes\Core\Service\MapCalculator;

class OrthographicMapCalculator implements MapCalculator
{
    private $width;
    private $height;
    private $tileWidth;
    private $tileHeight;
    private $viewPortWidth;
    private $viewPortHeight;

    public function __construct($height, $width, $viewPortHeight, $viewPortWidth, $tileHeight, $tileWidth)
    {
        $this->width = $width;
        $this->tileWidth = $tileWidth;
        $this->tileHeight = $tileHeight;
        $this->height = $height;
        $this->viewPortHeight = $viewPortHeight;
        $this->viewPortWidth = $viewPortWidth;
    }

    public function getArea($top, $left)
    {

        $halfViewportWidth = round($this->viewPortWidth/2);
        $halfViewportHeight = round($this->viewPortHeight/2);
        $topPosition = $top-$halfViewportHeight;
        $bottomPosition = $top+$halfViewportHeight;
        $leftPosition =$left-$halfViewportWidth;
        $rightPosition = $left+$halfViewportWidth;

        $area = array();
        for ($y = $topPosition; $y < $bottomPosition; $y +=$this->tileHeight) {
            for ($x = $leftPosition; $x < $rightPosition; $x +=$this->tileWidth) {
                $position = $this->pixelToPosition($y,$x);
                $positionX = max(0, min($this->width, $position['posX']));
                $positionY = max(0, min($this->height,$position['posY']));
                $key = sprintf("%d-%d", $positionY, $positionX);
                $area[$key] = array('posY' => $positionY, 'posX' => $positionX);
            }
        }

        return $area;
    }

    /**
     * @param $height
     * @param $width
     * @return void
     */
    public function setViewport($height, $width)
    {
        $this->viewPortWidth = $width;
        $this->viewPortHeight = $height;
    }

    public function positionToPixel($posY, $posX)
    {
        $left = $posX * $this->tileWidth;
        $top = $posY * $this->tileHeight;
        return array(
            'left' => $left,
            'top' => $top
        );
    }

    public function pixelToPosition($top, $left)
    {
        $posX = $left / $this->tileWidth;
        $posY = $top / $this->tileHeight;
        return array(
            'posX' => (int)round($posX),
            'posY' => (int)round($posY)
        );
    }

    public function getCenterPosition($posY, $posX)
    {
        $position = $this->positionToPixel($posY, $posX);
        $left = $position['left'];
        $top = $position['top'];

        $posX = -$left + $this->viewPortWidth / 2 ;
        $posY = -$top + $this->viewPortHeight / 2;

        $result = array(
            'top' => $posY,
            'left' => $posX
        );

        return $result;
    }

    public function getNeighborLocations($posY, $posX, $range = 1)
    {

    }

}
