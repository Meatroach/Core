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
use OpenTribes\Core\Resource as BaseResource;

/**
 * City Resource relationship Entity
 */
class Resource extends Entity {

    /**
     * @var Integer $amount
     */
    protected $amount;

    /**
     * @var \OpenTribes\Core\City $city
     */
    protected $city;

    /**
     * @var \OpenTribes\Core\Resource $resource
     */
    protected $resource;

    /**
     * @return \Integer $amount
     */
    public function getAmount() {
        return $this->amount;
    }

    /**
     * @return \OpenTribes\Core\Resource $resource
     */
    public function getResource() {
        return $this->resource;
    }

    /**
     * @return \OpenTribes\Core\City $city
     */
    public function getCity() {
        return $this->city;
    }

    /**
     * @param \OpenTribes\Core\City $city
     * @return \OpenTribes\Core\City\Resource
     */
    public function setCity(City $city) {
        $this->city = $city;
        return $this;
    }

    /**
     * @param \OpenTribes\Core\Resource $resource
     * @return \OpenTribes\Core\City\Resource
     */
    public function setResource(BaseResource $resource) {
        $this->resource = $resource;
        return $this;
    }

    /**
     * @param Ingeger $amount
     * @return \OpenTribes\Core\City\Resource
     */
    public function setAmount($amount) {
        $this->amount = (int) $amount;
        return $this;
    }

}
