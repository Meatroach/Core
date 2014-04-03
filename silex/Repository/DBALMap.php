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
    private $map      = null;
    private $db;
    private $added    = false;
    private $modified = false;
    private $deleted  = false;

    private function reassign() {
        if ($this->added) {
            $this->added = false;
        }
        if ($this->modified) {
            $this->modified = false;
        }
        if ($this->deleted) {
            $this->deleted = false;
        }
    }

    public function __construct(Connection $db) {
        $this->db = $db;
    }

    public function add(MapEntity $map) {
        $this->map   = $map;
        $this->reassign();
        $this->added = true;
    }

    public function create($id,$name) {
        return new MapEntity($id,$name);
    }
    
    private function entityToRow(MapEntity $map) {
        return array(
            'id'     => $map->getId(),
            'name'   => $map->getName(),
            'width'  => $map->getWidth(),
            'height' => $map->getHeight()
        );
    }

    public function sync() {
        if ($this->map && $this->added) {
            $this->db->insert('maps', $this->entityToRow($this->map));
        }
        if ($this->map && $this->modified) {
            $this->db->update('maps', $this->entityToRow($this->map), array('id' => $this->map->getId()));
        }
        if ($this->map && $this->added) {
            $this->db->delete('maps', array('id' => $this->map->getId()));
        }
    }
    public function getUniqueId() {
        return 1;
    }
}
