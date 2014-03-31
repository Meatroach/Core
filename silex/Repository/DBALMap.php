<?php

namespace OpenTribes\Core\Silex\Repository;

use OpenTribes\Core\Entity\Map as MapEntity;
use OpenTribes\Core\Repository\Map as MapRepository;
use Doctrine\DBAL\Connection;
/**
 * Description of Map
 *
 * @author BlackScorp<witalimik@web.de>
 */
class DBALMap implements MapRepository {

    /**
     * @var MapEntity
     */
    private $map = null;
    private $db;
    public function __construct(Connection $db) {
        $this->db = $db;
    }

    public function add(MapEntity $map) {
        $this->map = $map;
    }

    public function create($name) {
        return new MapEntity($name);
    }

    public function getTile($y, $x) {
        return $this->map->getTile($y, $x);
    }

    public function tileIsAccessible($y, $x) {
        $tile = $this->map->getTile($y, $x);
        if (!$tile) {
            return false;
        }
        
        return $tile->isAccessible();
    }
    public function getCenterX() {
        return $this->map->getWidth()/2;
    }
    public function getCenterY() {
        return $this->map->getHeight()/2;
    }
}
