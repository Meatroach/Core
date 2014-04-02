<?php

namespace OpenTribes\Core\Silex\Repository;

use OpenTribes\Core\Repository\MapTiles as MapTilesRepository;
use OpenTribes\Core\Entity\Map as MapEntity;
use OpenTribes\Core\Entity\Tile as TileEntity;
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
        $sql       = "SELECT m.name as mapName,m.width as mapWidth,m.height as mapHeight,t.id as tileId,t.name as tileName,t.accessible as accessible as mapName,mt.x as x,mt.y as y FROM map m INNER JOIN map_tiles mt ON(m.id=mt.map_id) INNER JOIN tiles t ON(t.id = mt.tile_id)";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result    = $statement->fetchAll(\PDO::FETCH_OBJ);
        $tiles     = array();
        $map       = $this->map;
        foreach ($result as $row) {
            
            if (!$map) {
                $map = new MapEntity($row->mapName);
                $map->setHeight($row->mapWidth);
                $map->setHeight($row->mapHeight);
            }
            $tile = isset($tiles[$row->tileId]) ? $tiles[$row->tileId] : null;
            if (!$tile) {
                $tile                  = new TileEntity($row->tileId, $row->tileName, $row->accessible);
                $tiles[$tile->getId()] = $tile;
            }
            $map->addTile($tile, $row->y, $row->x);
            $this->add($map);
        }
    }

}
