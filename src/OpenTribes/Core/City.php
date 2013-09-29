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
    

    protected $name;

    protected $owner;
  
    public function setOwner(User $user) {
        $this->owner = $user;
        return $this;
    }

  
  
    public function getOwner() {
        return $this->owner;
    }
    public function setName($name){
        $this->name = $name;
        return $this;
    }
    public function getName(){
        return $this->name;
    }
}