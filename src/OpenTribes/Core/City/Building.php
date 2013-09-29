<?php

/**
 * This file is part of the "Open Tribes" Core Module.
 *
 * @package    OpenTribes\Core
 * @author     Witali Mik <mik@blackscorp.de>
 * @copyright  (c) 2013 BlackScorp Games
 * @license    For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace OpenTribes\Core\City;

use OpenTribes\Core\Entity;
use OpenTribes\Core\City;
use OpenTribes\Core\Building as BaseBuilding;

/**
 * City Building relationship Entity
 */
class Building extends Entity {

    /**
     * @var Integer $level 
     */
    protected $level;

    /**
     * @var \OpenTribes\Core\Building $building
     */
    protected $building;

    /**
     * @var \OpenTribes\Core\City $city
     */
    protected $city;

    /**
     * @param Integer $level
     * @return \OpenTribes\Core\City\Building
     */
    public function setLevel($level) {
        $this->level = (int) $level;
        return $this;
    }

    /**
     * @param \OpenTribes\Core\Building $building
     * @return \OpenTribes\Core\City\Building
     */
    public function setBuilding(BaseBuilding $building) {
        $this->building = $building;
        return $this;
    }

    /**
     * @param \OpenTribes\Core\City $city
     * @return \OpenTribes\Core\City\Building
     */
    public function setCity(City $city) {
        $this->city = $city;
        return $this;
    }

    /**
     * @return \Integer $level
     */
    public function getLevel() {
        return $this->level;
    }

    /**
     * @return \OpenTribes\Core\Building $building
     */
    public function getBuilding() {
        return $this->building;
    }

    /**
     * @return \OpenTribes\Core\City $city
     */
    public function getCity() {
        return $this->city;
    }

}