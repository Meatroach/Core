<?php

namespace OpenTribes\Core\Silex\Repository;

use Doctrine\DBAL\Connection;
use OpenTribes\Core\Entity\Tile as TileEntity;
use OpenTribes\Core\Repository\Tile as TileRepository;

/**
 * Description of DBALTile
 *
 * @author BlackScorp<witalimik@web.de>
 */
class DBALTile extends Repository implements TileRepository
{

    /**
     * @var TileEntity[]
     */
    private $tiles = array();
    /**
     *
     * @var \Doctrine\DBAL\Connection
     */
    private $db;

    /**
     * @param Connection $db DBAL Connection
     */
    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function add(TileEntity $tile)
    {
        $id = $tile->getTileId();
        $this->tiles[$id] = $tile;
        parent::markAdded($id);
    }

    public function create($id, $name, $isAccessible)
    {
        return new TileEntity($id, $name, $isAccessible);
    }

    public function findById($id)
    {
        foreach ($this->tiles as $tile) {
            if ($tile->getTileId() === $id) {
                return $tile;
            }
        }
    }

    public function findByName($name)
    {
        $found = array();
        foreach ($this->tiles as $tile) {
            if ($tile->getName() === $name) {
                $found[$tile->getTileId()] = $tile;
            }
        }
        return $found;
    }

    public function getUniqueId()
    {
        $result = $this->db->prepare("SELECT MAX(cityId) FROM tiles");
        $result->execute();
        $row = $result->fetchColumn();
        $row += count($this->tiles);
        $row -= count(parent::getDeleted());
        return (int)($row + 1);
    }

    private function entityToRow(TileEntity $tile)
    {
        return array(
            'cityId' => $tile->getTileId(),
            'name' => $tile->getName(),
            'width' => $tile->getWidth(),
            'height' => $tile->getHeight(),
            'is_default' => $tile->isDefault(),
            'is_accessible' => $tile->isAccessible()
        );
    }

    public function sync()
    {
        foreach (parent::getDeleted() as $id) {
            if (isset($this->tiles[$id])) {
                $this->db->delete('tiles', array('cityId' => $id));
                unset($this->tiles[$id]);
                parent::reassign($id);
            }
        }

        foreach (parent::getAdded() as $id) {
            if (isset($this->tiles[$id])) {
                $user = $this->tiles[$id];
                $this->db->insert('tiles', $this->entityToRow($user));
                parent::reassign($id);
            }
        }
        foreach (parent::getModified() as $id) {
            if (isset($this->tiles[$id])) {
                $user = $this->tiles[$id];
                $this->db->update('tiles', $this->entityToRow($user), array('cityId' => $id));
                parent::reassign($id);
            }
        }
    }

}
