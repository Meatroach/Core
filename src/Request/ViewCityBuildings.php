<?php

namespace OpenTribes\Core\Request;

/**
 * Description of ViewBuildings
 *
 * @author BlackScorp<witalimik@web.de>
 */
class ViewCityBuildings {

    private $y;
    private $x;

    function __construct($y, $x) {
        $this->y = (int) $y;
        $this->x = (int) $x;
    }

    public function getY() {
        return $this->y;
    }

    public function getX() {
        return $this->x;
    }

}
