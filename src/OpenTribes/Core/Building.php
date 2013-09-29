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
 * Building Entity
 */
class Building extends Entity {

    /**
     * @var Integer $minimumLevel
     */
    protected $minimumLevel;

    /**
     * @var Integer $maximumLevel
     */
    protected $maximumLevel;

    /**
     * @var String $name
     */
    protected $name;

    /**
     * @param String $name
     * @return \OpenTribes\Core\Building
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * @param Integer $level
     * @return \OpenTribes\Core\Building
     */
    public function setMinimumLevel($level) {
        $this->minimumLevel = (int) $level;
        return $this;
    }

    /**
     * @param Integer $level
     * @return \OpenTribes\Core\Building
     */
    public function setMaximumLevel($level) {
        $this->maximumLevel = (int) $level;
        return $this;
    }

    /**
     * @return \Integer $maximumLevel
     */
    public function getMaximumLevel() {
        return $this->maximumLevel;
    }

    /**
     * @return \Integer $minimumLevel
     */
    public function getMinimumLevel() {
        return $this->minimumLevel;
    }

    /**
     * @return \String $name
     */
    public function getName() {
        return $this->name;
    }

}
