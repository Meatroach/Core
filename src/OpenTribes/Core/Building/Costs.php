<?php

/**
 * This file is part of the "Open Tribes" Core Module.
 *
 * @package    OpenTribes\Core
 * @author     Witali Mik <mik@blackscorp.de>
 * @copyright  (c) 2013 BlackScorp Games
 * @license    For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace OpenTribes\Core\Building;

use OpenTribes\Core\Entity;
use OpenTribes\Core\Building;
use OpenTribes\Core\Resource;

/**
 * Building Costs Entity
 */
class Costs extends Entity {

    /**
     * @var \OpenTribes\Core\Building $building
     */
    private $building;

    /**
     * @var \OpenTribes\Core\Resource $resource
     */
    private $resource;

    /**
     * @var Integer $value
     */
    private $value;

    /**
     * @var Double $factor
     */
    private $factor;

    /**
     * @param \OpenTribes\Core\Building $building
     * @return \OpenTribes\Core\Building\Costs
     */
    public function setBuilding(Building $building) {
        $this->building = $building;
        return $this;
    }

    /**
     * @param \OpenTribes\Core\Resource $resource
     * @return \OpenTribes\Core\Building\Costs
     */
    public function setResource(Resource $resource) {
        $this->resource = $resource;
        return $this;
    }

    /**
     * @param Integer $value
     * @return \OpenTribes\Core\Building\Costs
     */
    public function setValue($value) {
        $this->value = (int) $value;
        return $this;
    }

    /**
     * @param Double $factor
     * @return \OpenTribes\Core\Building\Costs
     */
    public function setFactor($factor) {
        $this->factor = (double) $factor;
        return $this;
    }

    /**
     * @return \OpenTribes\Core\Building $building
     */
    public function getBuilding() {
        return $this->building;
    }

    /**
     * @return \OpenTribes\Core\Resource $resource
     */
    public function getResource() {
        return $this->resource;
    }

    /**
     * @return \Integer $value
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * @return \Double $factor
     */
    public function getFactor() {
        return $this->factor;
    }

}
