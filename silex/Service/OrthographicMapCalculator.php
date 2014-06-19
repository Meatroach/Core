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

    function __construct($height, $width, $viewPortHeight, $viewPortWidth, $tileHeight, $tileWidth)
    {
        $this->width = $width;
        $this->tileWidth = $tileWidth;
        $this->tileHeight = $tileHeight;
        $this->height = $height;
        $this->viewPortHeight = $viewPortHeight;
        $this->viewPortWidth = $viewPortWidth;
    }

    public function getArea($posY, $posX)
    {
        // TODO: Implement getArea() method.
    }

    /**
     * @return void
     */
    public function setViewport($height, $width)
    {
        $this->viewPortWidth = $width;
        $this->viewPortHeight = $height;
    }

    public function positionToPixel($posY, $posX)
    {
        $left = $posX * $this->width * $this->tileWidth;
        $top = $posY * $this->height * $this->tileHeight;
        return array(
            'left' => $left,
            'top' => $top
        );
    }

    public function pixelToPosition($top, $left)
    {
        $x = $left / $this->tileWidth;
        $y = $top / $this->tileHeight;
        return array(
            'posX' => $x,
            'posY' => $y
        );
    }

    public function getCenterPosition($posY, $posX)
    {
        // TODO: Implement getCenterPosition() method.
    }

} 