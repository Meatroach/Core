<?php

namespace OpenTribes\Core\Silex\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use OpenTribes\Core\Entity\City as CityEntity;
use OpenTribes\Core\Entity\User as UserEntity;
use OpenTribes\Core\Repository\City as CityInterface;
use PDO;
use stdClass;

/**
 * Description of DBALCity
 *
 * @author BlackScorp<witalimik@web.de>
 */
class DBALCity extends Repository implements CityInterface {

    /**
     * @var CityEntity[]
     */
    private $cities = array();
    private $db;

    /**
     * @param Connection $db
     */
    public function __construct(Connection $db) {
        $this->db = $db;
    }

    /**
     * {@inheritDoc}
     */
    public function add(CityEntity $city) {
        $id                = $city->getId();
        $this->cities[$id] = $city;
        parent::markAdded($id);
    }

    /**
     * {@inheritDoc}
     */
    public function cityExistsAt($y, $x) {
        $y = (int) $y;
        $x = (int) $x;
        foreach ($this->cities as $city) {
            if ($city->getX() === $x && $city->getY() === $y) {
                return true;
            }
        }
        $result = $this->getQueryBuilder()
                        ->where('x = :x AND y = :y')
                        ->setParameters(array(
                            ':y' => $y,
                            ':x' => $x
                        ))->execute();

        $row = $result->fetch(PDO::FETCH_OBJ);

        return (bool) $row;
    }

    /**
     * {@inheritDoc}
     */
    public function create($id, $name, UserEntity $owner, $y, $x) {
        return new CityEntity($id, $name, $owner, $y, $x);
    }

    /**
     * {@inheritDoc}
     */
    public function findAllByOwner(UserEntity $owner) {
        $found = array();
        foreach ($this->cities as $city) {
            if ($city->getOwner() === $owner) {
                $found[$city->getId()] = $city;
            }
        }

        $result = $this->getQueryBuilder()
                        ->where('user_id = :user_id')
                        ->setParameter(':user_id', $owner->getId())->execute();
        $rows   = $result->fetchAll(PDO::FETCH_OBJ);
        if (count($rows) < 0) {
            return $found;
        }
        foreach ($rows as $row) {
            $entity                  = $this->rowToEntity($row);
            $found[$entity->getId()] = $entity;
            $this->replace($entity);
        }
        return $found;
    }

    /**
     * @return QueryBuilder
     */
    private function getQueryBuilder() {
        $queryBuilder = $this->db->createQueryBuilder();
        return $queryBuilder->select('u.id AS userId', 'u.username', 'u.password', 'u.email', 'c.id AS cityId', 'c.name AS cityName', 'c.x', 'c.y', 'c.is_main AS isMain')
                        ->from('users', 'u')->innerJoin('u', 'cities', 'c', 'u.id=c.user_id');
    }

    /**
     * {@inheritDoc}
     */
    public function findByLocation($y, $x) {
        foreach ($this->cities as $city) {
            if ($city->getX() === $x && $city->getY() === $y) {
                return $city;
            }
        }
        $result = $this->getQueryBuilder()
                        ->where('x = :x')
                        ->where('y = :y')
                        ->setParameters(array(
                            ':y' => $y,
                            ':x' => $x
                        ))->execute();
        $row    = $result->fetch(PDO::FETCH_OBJ);
        if (!$row) {
            return null;
        }
        $entity = $this->rowToEntity($row);
        $this->replace($entity);
        return $entity;
    }

    /**
     * {@inheritDoc}
     */
    public function delete(CityEntity $city) {
        $id = $city->getId();
        parent::markDeleted($id);
    }

    /**
     * {@inheritdoc}
     */
    public function getUniqueId() {
        $result = $this->db->prepare("SELECT MAX(id) FROM cities");
        $result->execute();
        $row    = $result->fetchColumn();
        $row += count($this->cities);
        $row -= count(parent::getDeleted());
        return (int) ($row + 1);
    }

    /**
     * {@inheritDoc}
     */
    public function replace(CityEntity $city) {
        $id                = $city->getId();
        $this->cities[$id] = $city;
        parent::markModified($id);
    }

    /**
     * {@inheritDoc}
     */
    public function countAll() {
        $result = $this->db->prepare("SELECT COUNT(id) FROM cities");
        $result->execute();
        $row    = $result->fetchColumn();
        return (int) $row;
    }

    private function rowToEntity(stdClass $row) {
        $owner = new UserEntity($row->userId, $row->username, $row->password, $row->email);
        $city  = $this->create($row->cityId, $row->cityName, $owner, $row->y, $row->x);
        $city->setMain($row->isMain);
        return $city;
    }

    private function entityToRow(CityEntity $city) {
        return array(
            'id'      => $city->getId(),
            'name'    => $city->getName(),
            'x'       => $city->getX(),
            'y'       => $city->getY(),
            'user_id' => $city->getOwner()->getId(),
            'is_main' => $city->isMain()
        );
    }

    /**
     * {@inheritDoc}
     */
    public function sync() {
        foreach (parent::getDeleted() as $id) {
            if (isset($this->cities[$id])) {
                $this->db->delete('cities', array('id' => $id));
                unset($this->cities[$id]);
                parent::reassign($id);
            }
        }
        foreach (parent::getAdded() as $id) {
            if (isset($this->cities[$id])) {
                $cities = $this->cities[$id];
                $this->db->insert('cities', $this->entityToRow($cities));
                parent::reassign($id);
            }
        }
        foreach (parent::getModified() as $id) {
            if (isset($this->cities[$id])) {
                $cities = $this->cities[$id];
                $this->db->update('cities', $this->entityToRow($cities), array('id' => $id));
                parent::reassign($id);
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function flush() {
        return $this->db->exec("DELETE FROM cities");
    }

    /**
     * {@inheritDoc}
     */
    public function findMainByUsername($username) {
        foreach ($this->cities as $city) {
            if ($city->getOwner()->getUsername() === $username && $city->isMain()) {
                return $city;
            }
        }
    }

    public function findAllInArea(array $area) {
        $where    = 'CONCAT(y,"-",x)';
        $params   = $this->db->getParams();
        $isSQLite = $params['driver'] === 'pdo_sqlite';

        if ($isSQLite) {
            $where = '(y||"-"||x)';
        }
        $result = $this->getQueryBuilder()->where($where . ' IN (\'' . implode("','", array_keys($area)) . '\')')->execute();
        $rows   = $result->fetchAll(PDO::FETCH_OBJ);
        $found  = array();
        if (count($rows) < 0) {
            return $found;
        }
        foreach ($rows as $row) {
            $entity                  = $this->rowToEntity($row);
            $found[$entity->getId()] = $entity;
            $this->replace($entity);
        }
        return $found;
    }

}
