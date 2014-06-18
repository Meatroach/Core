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

    public function getArea($y, $x)
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

    public function positionToPixel($y, $x)
    {
        $left = $x * $this->width * $this->tileWidth;
        $top = $y * $this->height * $this->tileHeight;
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
            'x' => $x,
            'y' => $y
        );
    }

    public function getCenterPosition($y, $x)
    {
        // TODO: Implement getCenterPosition() method.
    }

} 