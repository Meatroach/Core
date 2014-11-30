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
class DBALMapTiles implements MapTilesRepository
{

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var MapEntity
     */
    private $map;

    /**
     * @var TileEntity
     */
    private $defaultTile;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * {@inheritDoc}
     */
    public function add(MapEntity $map)
    {
        $this->map = $map;
    }

    /**
     * @return MapEntity
     */
    public function getMap()
    {
        if ($this->map) {
            return $this->map;
        }
        $this->load();
        return $this->map;
    }

    /**
     * @return QueryBuilder
     */
    private function getQueryBuilder()
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        return $queryBuilder->select(
            'm.map_id AS mapId',
            'm.name AS mapName',
            'm.width as mapWidth',
            'm.height AS mapHeight',
            't.tile_id AS tileId',
            't.name AS tileName',
            't.is_accessible AS isAccessible',
            't.is_default AS isDefault',
            'mt.posX AS posX',
            'mt.posY AS posY',
            't.width AS tileWidth',
            't.height as tileHeight'
        )->from('maps', 'm')->leftJoin('m', 'map_tiles', 'mt', 'm.map_id=mt.map_id')->leftJoin(
                'mt',
                'tiles',
                't',
                'mt.tile_id=t.tile_id'
            );
    }

    private function loadDefaultTile()
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $result = $queryBuilder->select(
            't.tile_id',
            't.name',
            't.is_accessible AS isAccessible',
            't.width',
            't.height',
            't.is_default AS isDefault'
        )
            ->from('tiles', 't')
            ->where('is_default = 1')->execute();
        $row = $result->fetch(PDO::FETCH_OBJ);
        $this->defaultTile = new TileEntity($row->tile_id, $row->name, $row->isAccessible);
        $this->defaultTile->setDefault($row->isDefault);
        $this->defaultTile->setHeight($row->height);
        $this->defaultTile->setWidth($row->width);
    }

    private function rowsToEntities(array $rows)
    {
        $tiles = array();
        $map = $this->map;
        foreach ($rows as $row) {


            if (!$map) {
                $map = new MapEntity($row->mapId, $row->mapName);
                $map->setWidth($row->mapWidth);
                $map->setHeight($row->mapHeight);
            }
            $tile = isset($tiles[$row->tileId]) ? $tiles[$row->tileId] : null;
            if (!$tile) {
                $tile = new TileEntity($row->tileId, $row->tileName, $row->isAccessible);
                $tile->setDefault($row->isDefault);
                $tile->setHeight($row->tileHeight);
                $tile->setWidth($row->tileWidth);
                $tiles[$tile->getTileId()] = $tile;
            }
            $map->addTile($tile, $row->posY, $row->posX);
            $this->add($map);
        }
    }

    private function load()
    {

        $result = $this->getQueryBuilder()->execute();
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $this->rowsToEntities($rows);
    }

    public function getDefaultTile()
    {
        if (!$this->defaultTile) {
            $this->loadDefaultTile();
        }
        return $this->defaultTile;
    }

    public function findAllInArea(array $area)
    {
        $where = 'CONCAT(posY,"-",posX)';
        $params = $this->connection->getParams();
        $isSQLite = $params['driver'] === 'pdo_sqlite';

        if ($isSQLite) {
            $where = '(posY||"-"||posX)';
        }
        $result = $this->getQueryBuilder()
            ->where($where . ' IN (\'' . implode("','", array_keys($area)) . '\') ');

        $statement = $result->execute();
        $rows = $statement->fetchAll(PDO::FETCH_OBJ);
        $this->rowsToEntities($rows);
        return $this->map;
    }

    public function sync()
    {
        $mapTiles = $this->map->getTiles();
        $sql = "INSERT INTO map_tiles(map_id,tile_id,posX,posY) VALUES (:map_id,:tile_id,:posX,:posY)";
        $statement = $this->connection->prepare($sql);
        foreach ($mapTiles as $y => $rows) {
            foreach ($rows as $x => $tile) {
                if ($tile->isDefault()) {
                    continue;
                }
                $data = array(
                    'map_id' => $this->map->getMapId(),
                    'tile_id' => $tile->getTileId(),
                    'posX' => $x,
                    'posY' => $y
                );

                $statement->execute($data);
            }
        }
    }
}
