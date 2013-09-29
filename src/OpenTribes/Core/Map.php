<?php

/**
 * This file is part of the "Open Tribes" Core Module.
 *
 * @package    OpenTribes\Core
 * @author     Witali Mik <mik@blackscorp.de>
 * @copyright  (c) 2013 BlackScorp Games
 * @license    For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace OpenTribes\Core;

/**
 * Map Entity
 */
class Map extends Entity {

    /**
     * @var String $name 
     */
    protected $name;

    /**
     * @param String $name
     * @return \OpenTribes\Core\Map
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * @return \String $name
     */
    public function getName() {
        return $this->name;
    }

}