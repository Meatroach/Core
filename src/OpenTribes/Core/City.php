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
 * A basic City class
 */
class City extends Entity {

    /**
     * @var String $name
     */
    protected $name;

    /**
     * @var \OpenTribes\Core\User $owner
     */
    protected $owner;

    /**
     * @param \OpenTribes\Core\User $user
     * @return \OpenTribes\Core\City
     */
    public function setOwner(User $user) {
        $this->owner = $user;
        return $this;
    }

    /**
     * @return \OpenTribes\Core\User $owner
     */
    public function getOwner() {
        return $this->owner;
    }

    /**
     * @param String $name
     * @return \OpenTribes\Core\City
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