<?php

namespace OpenTribes\Core\Response;

/**
 * Description of ViewCityBuildings
 *
 * @author BlackScorp<witalimik@web.de>
 */
class ViewLocation extends Response{
    public $isCustomCity = false;
    public $buildings = array();
    public $city = null;
}
