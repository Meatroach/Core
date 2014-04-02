<?php

namespace OpenTribes\Core\Silex\Repository;

use OpenTribes\Core\Repository\MapTiles as MapTilesRepository;
use OpenTribes\Core\Entity\Map as MapEntity;
use Doctrine\DBAL\Connection;

/**
 * Description of DBALMapTiles
 *
 * @author Witali
 */
class DBALMapTiles implements MapTilesRepository {
    /**
     * @var Connection
     */
    private $db;

    /**
     * @var MapEntity
     */
    private $map;

    public function __construct(Connection $db) {
        $this->db = $db;
    }

    public function add(MapEntity $map) {
        $this->map = $map;
    }

    public function getMap() {
        if ($this->map) return $this->map;
        $this->load();
        return $this->map;
    }
    private function load() {
        $sql = "SELECT * FROM map m INNER JOIN map_tiles mt ON(m.id=mt.map_id) INNER JOIN tiles t ON(t.id = mt.tile_id)";
    }

}
