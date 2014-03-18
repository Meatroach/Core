<?php

namespace OpenTribes\Core\Request;

/**
 * Description of SelectLocation
 *
 * @author BlackScorp<witalimik@web.de>
 */
class SelectLocation {
    private $direction;
    function __construct($direction) {
        $this->direction = $direction;
    }
    public function getDirection() {
        return $this->direction;
    }


}
