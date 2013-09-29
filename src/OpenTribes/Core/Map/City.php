<?php
/**
 * This file is part of the "Open Tribes" Core Module.
 *
 * @package    OpenTribes\Core
 * @author     Witali Mik <mik@blackscorp.de>
 * @copyright  (c) 2013 BlackScorp Games
 * @license    For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */
namespace OpenTribes\Core\Map;

use OpenTribes\Core\Entity;
use OpenTribes\Core\Map;
use OpenTribes\Core\City as BaseCity;
/**
 * Map City relationship Entity
 */
class City extends Entity{
    /**
     * @var Integereger $x
     */
    protected $x;
    /**
     * @var Integereger $y
     */
    protected $y;
    /**
     * @var \OpenTribes\Core\City $tile
     */
    protected $city;
    /**
     * @var \OpenTribes\Core\Map $map
     */
    protected $map;
    
    /**
     * @param \OpenTribes\Core\Map $map
     * @return \OpenTribes\Core\Map\Tile
     */
    public function setMap(Map $map){
        $this->map = $map;
        return $this;
    }
    /**
     * @param \OpenTribes\Core\City $city
     * @return \OpenTribes\Core\Map\Tile
     */
    public function setCity(BaseCity $city){
        $this->city = $city;
        return $this;
    }
    /**
     * @param Integer $x
     * @return \OpenTribes\Core\Map\Tile
     */
    public function setX($x){
        $this->x = (int)$x;
        return $this;
    }
    /**
     * @param Integer $y
     * @return \OpenTribes\Core\Map\Tile
     */
    public function setY($y){
        $this->y = (int)$y;
        return $this;
    }
    /**
     * @return \OpenTribes\Core\Map $map
     */
    public function getMap(){
        return $this->map;
    }
    /**
     * @return \OpenTribes\Core\City $city
     */
    public function getCity(){
        return $this->city;
    }
    /**
     * @return Integer $x
     */
    public function getX(){
        return $this->x;
    }
    /**
     * @return Integer $y
     */
    public function getY(){
        return $this->y;
    }
}
