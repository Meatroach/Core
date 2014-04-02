<?php

namespace OpenTribes\Core\Silex\Repository;

use Doctrine\DBAL\Connection;
use OpenTribes\Core\Entity\City as CityEntity;
use OpenTribes\Core\Entity\User as UserEntity;
use OpenTribes\Core\Repository\City as CityInterface;
use stdClass;

/**
 * Description of DBALCity
 *
 * @author BlackScorp<witalimik@web.de>
 */
class DBALCity implements CityInterface {

    /**
     * @var CityEntity[]
     */
    private $cities   = array();
    private $db;
    private $added    = array();
    private $modified = array();
    private $deleted  = array();

    public function __construct(Connection $db) {
        $this->db = $db;
    }

    public function add(CityEntity $city) {
        $id                = $city->getId();
        $this->reassign($id);
        $this->cities[$id] = $city;
        $this->added[$id]  = $id;
    }

    public function cityExistsAt($y, $x) {
        $result = $this->db->prepare("SELECT 1 FROM cities WHERE y = :y AND x = :x ");
        $result->execute(array(
            ':y' => $y,
            ':x' => $x
        ));
        return (bool) $result->fetchColumn();
    }

    public function create($id, $name, UserEntity $owner, $y, $x) {
        return new CityEntity($id, $name, $owner, $y, $x);
    }

    public function findAllByOwner(UserEntity $owner) {
        
    }

    public function findByLocation($y, $x) {
        foreach ($this->cities as $city) {
            if ($city->getX() === $x && $city->getY() === $y) {
                return $city;
            }
        }
        $sql    = "SELECT * FROM cities c INNER JOIN users u ON(c.user_id = u.id) WHERE y =:y AND x = :x";
        $result = $this->db->prepare($sql);
        $result->execute(array(
            ':y' => $y,
            ':x' => $x
        ));
    }

    public function getUniqueId() {
        
    }

    public function replace(CityEntity $city) {
        
    }

    public function countAll() {
        ;
    }

    private function reassign($id) {
        if (isset($this->added[$id])) {
            unset($this->added[$id]);
        }
        if (isset($this->modified[$id])) {
            unset($this->modified[$id]);
        }
        if (isset($this->deleted[$id])) {
            unset($this->deleted[$id]);
        }
    }

    private function entityToRow(CityEntity $city) {
        return array(
            'id'      => $city->getId(),
            'name'    => $city->getName(),
            'x'       => $city->getX(),
            'y'       => $city->getY(),
            'user_id' => $city->getOwner()->getId()
        );
    }

    private function rowToEntity(stdClass $row) {
        
    }

    public function sync() {
        foreach ($this->deleted as $id) {
            if (isset($this->cities[$id])) {
                $cities = $this->cities[$id];
                $this->db->delete('cities', array('id' => $id));
                unset($this->cities[$id]);
                $this->reassign($id);
            }
        }
        foreach ($this->added as $id) {
            if (isset($this->cities[$id])) {
                $cities = $this->cities[$id];
                $this->db->insert('cities', $this->entityToRow($cities));
                $this->reassign($id);
            }
        }
        foreach ($this->modified as $id) {
            if (isset($this->cities[$id])) {
                $cities = $this->cities[$id];
                $this->db->update('cities', $this->entityToRow($cities), array('id' => $id));
                $this->reassign($id);
            }
        }
    }

}
