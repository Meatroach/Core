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
use OpenTribes\Core\Tile as BaseTile;
/**
 * Map Tile relationship Entity
 */
class Tile extends Entity{
    /**
     * @var Int $x
     */
    protected $x;
    /**
     * @var Int $y
     */
    protected $y;
    /**
     * @var \OpenTribes\Core\Tile $tile
     */
    protected $tile;
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
     * @param \OpenTribes\Core\Tile $tile
     * @return \OpenTribes\Core\Map\Tile
     */
    public function setTile(BaseTile $tile){
        $this->tile = $tile;
        return $this;
    }
    /**
     * @param Int $x
     * @return \OpenTribes\Core\Map\Tile
     */
    public function setX($x){
        $this->x = (int)$x;
        return $this;
    }
    /**
     * @param Int $y
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
     * @return \OpenTribes\Core\Tile $tile
     */
    public function getTile(){
        return $this->tile;
    }
    /**
     * @return Int $x
     */
    public function getX(){
        return $this->x;
    }
    /**
     * @return Int $y
     */
    public function getY(){
        return $this->y;
    }
}
