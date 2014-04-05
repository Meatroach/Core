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
class DBALMap extends Repository implements MapRepository {

    /**
     * @var MapEntity[]
     */
    private $maps;

    /**
     * @var Connection 
     */
    private $db;

    public function __construct(Connection $db) {
        $this->db = $db;
    }

    /**
     * {@inheritDoc}
     */
    public function add(MapEntity $map) {
        $id              = $map->getId();
        $this->maps[$id] = $map;
        parent::markAdded($id);
    }

    public function delete(MapEntity $map) {
        $id = $map->getId();
        parent::markDeleted($id);
    }

    public function replace(MapEntity $map) {
        $id              = $map->getId();
        $this->maps[$id] = $map;
        parent::markModified($id);
    }

    /**
     * {@inheritDoc}
     */
    public function create($id, $name) {
        return new MapEntity($id, $name);
    }

    private function rowToEntity(\stdClass $row) {
        $map = $this->create($row->id, $row->name);
        $map->setWidth($row->width);
        $map->setHeight($row->height);
        return $map;
    }

    private function entityToRow(MapEntity $map) {
        return array(
            'id'     => $map->getId(),
            'name'   => $map->getName(),
            'width'  => $map->getWidth(),
            'height' => $map->getHeight()
        );
    }

    /**
     * {@inheritDoc}
     */
    public function sync() {
        foreach (parent::getDeleted() as $id) {
            if (isset($this->maps[$id])) {
                $this->db->delete('maps', array('id' => $id));
                unset($this->maps[$id]);
                parent::reassign($id);
            }
        }

        foreach (parent::getAdded() as $id) {
            if (isset($this->maps[$id])) {
                $map = $this->maps[$id];
                $this->db->insert('maps', $this->entityToRow($map));
                parent::reassign($id);
            }
        }
        foreach (parent::getModified() as $id) {
            if (isset($this->maps[$id])) {
                $map = $this->maps[$id];
                $this->db->update('maps', $this->entityToRow($map), array('id' => $id));
                parent::reassign($id);
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getUniqueId() {
        $result = $this->db->prepare("SELECT MAX(id) FROM maps");
        $result->execute();
        $row    = $result->fetchColumn();

        return (int) ($row + 1);
    }

    /**
     * {@inheritDoc}
     */
    public function get() {
        return $this->map;
    }

    /**
     * {@inheritDoc}
     */
    public function findOneByName($name) {

        foreach ($this->maps as $map) {
            if ($map->getName() === $name) {
                return $map;
            }
        }
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder->select('id', 'name', 'width', 'height')->from('maps', 'm')->where('name = :name');
        $queryBuilder->setParameter(':name', $name);
        $result       = $queryBuilder->execute();
        $row          = $result->fetch(\PDO::FETCH_OBJ);
        $entity       = $this->rowToEntity($row);
        return $entity;
    }

}
