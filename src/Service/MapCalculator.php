<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace OpenTribes\Core\Service;

/**
 *
 * @author BlackScorp<witalimik@web.de>
 */
interface MapCalculator
{

    public function getArea($posY, $posX);

    /**
     * @return void
     */
    public function setViewport($height, $width);

    public function positionToPixel($posY, $posX);

    public function pixelToPosition($top, $left);

    public function getCenterPosition($posY, $posX);
}
