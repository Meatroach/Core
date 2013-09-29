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

use OpenTribes\Core\Entity;

/**
 * Role Entity class
 */
class Role extends Entity {

    /**
     * @var String $name 
     */
    private $name;

    /**
     * @param String $name
     * @return \OpenTribes\Core\Role
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * @return String $name
     */
    public function getName() {
        return $this->name;
    }

}