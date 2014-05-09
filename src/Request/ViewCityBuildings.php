<?php

namespace OpenTribes\Core\Request;

/**
 * Description of ViewCityy
 *
 * @author BlackScorp<witalimik@web.de>
 */
class ViewCityBuildings {

    private $y;
    private $x;

    public function __construct($y, $x) {

        $this->y        = $y;
        $this->x        = $x;
    }


    /**
     * @return integer
     */
    public function getY() {
        return $this->y;
    }

    /**
     * @return integer
     */
    public function getX() {
        return $this->x;
    }

}
