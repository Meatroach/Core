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

use OpenTribes\Core\User;

/**
 * A basic City class
 */
class City extends Entity {
    
    /** @type int $x */
    protected $x;
    
    /** @type int $y */
    protected $y;
    
    /** @type User $owner */
    protected $owner;
    
    /**
     * @api
     * 
     * @param User $user 
     * 
     * @return void
     */    
    public function setOwner(User $user) {
        $this->owner = $user;
    }

    /**
     * @api
     * 
     * @param int $x 
     * 
     * @return $this Provides a fluent interface.
     */ 
    public function setX($x) {
        $this->x = (int) $x;
        return $this;
    }
    
    /**
     * @api
     * 
     * @param int $y 
     * 
     * @return $this Provides a fluent interface.
     */ 
    public function setY($y) {
        $this->y = (int) $y;
        return $this;
    }
    
    /**
     * @api
     * 
     * @return int
     */ 
    public function getX() {
        return $this->x;
    }
    
    /**
     * @api
     * 
     * @return int
     */ 
    public function getY() {
        return $this->y;
    }
    
    /**
     * @api
     * 
     * @return Owner
     */ 
    public function getOwner() {
        return $this->owner;
    }
}