<?php

namespace OpenTribes\Core\Response;

/**
 * Description of ViewMap
 *
 * @author BlackScorp<witalimik@web.de>
 */
class ViewMap extends Response
{
    public $tiles = array();
    public $cities = array();
    public $width;
    public $height;
    public $left;
    public $top;
    public $upY;
    public $upX;
    public $downY;
    public $downX;
    public $leftX;
    public $leftY;
    public $rightX;
    public $rightY;
}
