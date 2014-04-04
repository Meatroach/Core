<?php

namespace OpenTribes\Core\Silex\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use OpenTribes\Core\Entity\Map as MapEntity;
use OpenTribes\Core\Entity\Tile as TileEntity;
use OpenTribes\Core\Repository\MapTiles as MapTilesRepository;
use PDO;

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

    /**
     * @param Connection $db
     */
    public function __construct(Connection $db) {
        $this->db = $db;
    }

    /**
     * {@inheritDoc}
     */
    public function add(MapEntity $map) {
        $this->map = $map;
    }

    /**
     * @return MapEntity
     */
    public function getMap() {
        if ($this->map) {
            return $this->map;
        }
        $this->load();
        return $this->map;
    }

    /**
     * @return QueryBuilder
     */
    private function getQueryBuilder() {
        $queryBuilder = $this->db->createQueryBuilder();
        return $queryBuilder->select('m.id AS mapId', 'm.name AS mapName', 'm.width as mapWidth', 'm.height AS mapHeight', 't.id AS tileId', 't.name AS tileName', 't.accessible AS isAccessible', 'mt.x AS x', 'mt.y AS y')->from('maps', 'm')->leftJoin('m', 'map_tiles', 'mt', 'm.id=mt.map_id')->leftJoin('mt', 'tiles', 't', 'mt.tile_id=t.id');
    }

    private function load() {

        $result = $this->getQueryBuilder()->execute();
        $rows   = $result->fetchAll(PDO::FETCH_OBJ);
        $tiles  = array();
        $map    = $this->map;


        foreach ($rows as $row) {

            if (!$map) {
                $map = new MapEntity($row->mapId, $row->mapName);
                $map->setWidth($row->mapWidth);
                $map->setHeight($row->mapHeight);
            }
            $tile = isset($tiles[$row->tileId]) ? $tiles[$row->tileId] : null;
            if (!$tile) {
                $tile                  = new TileEntity($row->tileId, $row->tileName, $row->isAccessible);
                $tiles[$tile->getId()] = $tile;
            }
            $map->addTile($tile, $row->y, $row->x);
            $this->add($map);
        }
    }

}
