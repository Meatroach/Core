<?php

namespace OpenTribes\Core\Silex\Repository;

use Doctrine\DBAL\Connection;
use OpenTribes\Core\Entity\Map as MapEntity;
use OpenTribes\Core\Repository\Map as MapRepository;

/**
 * Description of Map
 *
 * @author BlackScorp<witalimik@web.de>
 */
class DBALMap extends Repository implements MapRepository
{

    /**
     * @var MapEntity[]
     */
    private $maps;

    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * {@inheritDoc}
     */
    public function add(MapEntity $map)
    {
        $mapId = $map->getMapId();
        $this->maps[$mapId] = $map;
        parent::markAdded($mapId);
    }

    public function delete(MapEntity $map)
    {
        $mapId = $map->getMapId();
        parent::markDeleted($mapId);
    }

    public function replace(MapEntity $map)
    {
        $mapId = $map->getMapId();
        $this->maps[$mapId] = $map;
        parent::markModified($mapId);
    }

    /**
     * {@inheritDoc}
     */
    public function create($mapId, $name)
    {
        return new MapEntity($mapId, $name);
    }

    private function rowToEntity(\stdClass $row)
    {
        $map = $this->create($row->id, $row->name);
        $map->setWidth($row->width);
        $map->setHeight($row->height);
        return $map;
    }

    private function entityToRow(MapEntity $map)
    {
        return array(
            'cityId' => $map->getMapId(),
            'name' => $map->getName(),
            'width' => $map->getWidth(),
            'height' => $map->getHeight()
        );
    }

    /**
     * {@inheritDoc}
     */
    public function sync()
    {
        foreach (parent::getDeleted() as $id) {
            if (isset($this->maps[$id])) {
                $this->connection->delete('maps', array('cityId' => $id));
                unset($this->maps[$id]);
                parent::reassign($id);
            }
        }

        foreach (parent::getAdded() as $id) {
            if (isset($this->maps[$id])) {
                $map = $this->maps[$id];
                $this->connection->insert('maps', $this->entityToRow($map));
                parent::reassign($id);
            }
        }
        foreach (parent::getModified() as $id) {
            if (isset($this->maps[$id])) {
                $map = $this->maps[$id];
                $this->connection->update('maps', $this->entityToRow($map), array('cityId' => $id));
                parent::reassign($id);
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getUniqueId()
    {
        $result = $this->connection->prepare("SELECT MAX(cityId) FROM maps");
        $result->execute();
        $row = $result->fetchColumn();

        return (int)($row + 1);
    }

    /**
     * {@inheritDoc}
     */
    public function findOneByName($name)
    {

        foreach ($this->maps as $map) {
            if ($map->getName() === $name) {
                return $map;
            }
        }
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->select('cityId', 'name', 'width', 'height')->from('maps', 'm')->where('name = :name');
        $queryBuilder->setParameter(':name', $name);
        $result = $queryBuilder->execute();
        $row = $result->fetch(\PDO::FETCH_OBJ);
        $entity = $this->rowToEntity($row);
        return $entity;
    }
}
