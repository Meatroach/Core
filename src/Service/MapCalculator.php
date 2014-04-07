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
interface MapCalculator {
public function getArea($centerY,$centerX);
public function setTileWidth($width);
public function setTileHeight($height);

public function positionToPixel($y,$x);
public function pixelToPosition($top,$left);
}
