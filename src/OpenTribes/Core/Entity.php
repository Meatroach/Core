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

use OpenTribes\Core\Entity\Exception\UnknownProperty as UnknownPropertyException;

/**
 * A basic Entity class
 * 
 * Contains magic __get and __set methods to call getAttribute / setAttribute
 */
abstract class Entity {

    /**
     * @param string $name
     *
     * @throws UnknownPropertyException 
     *
     * @return mixed $value
     */
    public function __get($name) {
        $method = 'get' . $name;
        if (method_exists($this, $method)) {
            return $this->{$method};
        } else {
            throw new UnknownPropertyException(sprintf(
                "Cannot get unknown property '%s' in class %s", 
                $name, 
                get_class($this)
            ));
        }
    }


    /**
     * @param string $name
     * @param mixed $value
     *
     * @throws UnknownPropertyException 
     */
    public function __set($name, $value) {
        $method = 'set' . $name;
        if (method_exists($this, $method)) {
            $this->{$method}($value);
        } else {
            throw new UnknownPropertyException(sprintf(
                "Cannot set unknown property '%s' in class %s", 
                $name, 
                get_class($this)
            ));
        }
    }
}