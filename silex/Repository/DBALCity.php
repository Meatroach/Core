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
class DBALCity extends Repository implements CityInterface
{

    /**
     * @var CityEntity[]
     */
    private $cities = array();
    private $db;

    /**
     * @param Connection $db
     */
    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    /**
     * {@inheritDoc}
     */
    public function add(CityEntity $city)
    {
        $id = $city->getCityId();
        $this->cities[$id] = $city;
        parent::markAdded($id);
    }

    /**
     * {@inheritDoc}
     */
    public function cityExistsAt($posY, $posX)
    {
        $posY = (int)$posY;
        $posX = (int)$posX;
        foreach ($this->cities as $city) {
            if ($city->getPosX() === $posX && $city->getPosY() === $posY) {
                return true;
            }
        }
        $result = $this->getQueryBuilder()
            ->where('posX = :posX AND posY = :posY')
            ->setParameters(
                array(
                    ':posY' => $posY,
                    ':posX' => $posX
                )
            )->execute();

        $row = $result->fetch(PDO::FETCH_OBJ);

        return (bool)$row;
    }

    /**
     * {@inheritDoc}
     */
    public function create($id, $name, $y, $x)
    {
        return new CityEntity($id, $name, $y, $x);
    }

    /**
     * {@inheritDoc}
     */
    public function findAllByOwner(UserEntity $owner)
    {
        $found = array();
        foreach ($this->cities as $city) {
            if ($city->getOwner() === $owner) {
                $found[$city->getCityId()] = $city;
            }
        }

        $result = $this->getQueryBuilder()
            ->where('user_id = :user_id')
            ->setParameter(':user_id', $owner->getUserId())->execute();
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if (count($rows) < 0) {
            return $found;
        }
        foreach ($rows as $row) {
            $entity = $this->rowToEntity($row);
            $found[$entity->getCityId()] = $entity;
            $this->replace($entity);
        }
        return $found;
    }

    /**
     * @return QueryBuilder
     */
    private function getQueryBuilder()
    {
        $queryBuilder = $this->db->createQueryBuilder();
        return $queryBuilder->select(
            'u.cityId AS userId',
            'u.username',
            'u.password',
            'u.email',
            'c.cityId AS cityId',
            'c.name AS cityName',
            'c.posX',
            'c.posY',
            'c.is_selected AS isSelected'
        )
            ->from('users', 'u')->innerJoin('u', 'cities', 'c', 'u.cityId=c.user_id');
    }

    /**
     * {@inheritDoc}
     */
    public function findByLocation($posY, $posX)
    {
        foreach ($this->cities as $city) {
            if ($city->getPosX() === $posX && $city->getPosY() === $posY) {
                return $city;
            }
        }
        $result = $this->getQueryBuilder()
            ->where('posX = :posX')
            ->where('posY = :posY')
            ->setParameters(
                array(
                    ':posY' => $posY,
                    ':posX' => $posX
                )
            )->execute();
        $row = $result->fetch(PDO::FETCH_OBJ);
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
    public function delete(CityEntity $city)
    {
        $id = $city->getCityId();
        parent::markDeleted($id);
    }

    /**
     * {@inheritdoc}
     */
    public function getUniqueId()
    {
        $result = $this->db->prepare("SELECT MAX(cityId) FROM cities");
        $result->execute();
        $row = $result->fetchColumn();
        $row += count($this->cities);
        $row -= count(parent::getDeleted());
        return (int)($row + 1);
    }

    /**
     * {@inheritDoc}
     */
    public function replace(CityEntity $city)
    {
        $id = $city->getCityId();
        $this->cities[$id] = $city;
        parent::markModified($id);
    }

    /**
     * {@inheritDoc}
     */
    public function countAll()
    {
        $result = $this->db->prepare("SELECT COUNT(cityId) FROM cities");
        $result->execute();
        $row = $result->fetchColumn();
        $row += count($this->cities);
        $row -= count(parent::getDeleted());
        return (int)$row;
    }

    private function rowToEntity(stdClass $row)
    {
        $owner = new UserEntity($row->userId, $row->username, $row->password, $row->email);
        $city = $this->create($row->cityId, $row->cityName, $row->y, $row->x);
        $city->setOwner($owner);
        $city->setSelected($row->isSelected);
        return $city;
    }

    private function entityToRow(CityEntity $city)
    {
        return array(
            'cityId' => $city->getCityId(),
            'name' => $city->getName(),
            'posX' => $city->getPosX(),
            'posY' => $city->getPosY(),
            'user_id' => $city->getOwner()->getUserId(),
            'is_selected' => $city->isSelected()
        );
    }

    /**
     * {@inheritDoc}
     */
    public function sync()
    {
        $this->syncDeleted();
        $this->syncAdded();
        $this->syncModified();
    }

    private function syncAdded()
    {
        foreach (parent::getAdded() as $id) {
            if (isset($this->cities[$id])) {
                $cities = $this->cities[$id];
                $this->db->insert('cities', $this->entityToRow($cities));
                parent::reassign($id);
            }
        }
    }

    private function syncDeleted()
    {
        foreach (parent::getDeleted() as $id) {
            if (isset($this->cities[$id])) {
                $this->db->delete('cities', array('cityId' => $id));
                unset($this->cities[$id]);
                parent::reassign($id);
            }
        }
    }

    private function syncModified()
    {
        foreach (parent::getModified() as $id) {
            if (isset($this->cities[$id])) {
                $cities = $this->cities[$id];
                $this->db->update('cities', $this->entityToRow($cities), array('cityId' => $id));
                parent::reassign($id);
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function flush()
    {
        return $this->db->exec("DELETE FROM cities");
    }

    /**
     * {@inheritDoc}
     */
    public function findSelectedByUsername($username)
    {
        foreach ($this->cities as $city) {
            if ($city->getOwner()->getUsername() === $username && $city->isSelected()) {
                return $city;
            }
        }
        return null;
    }

    public function findAllInArea(array $area)
    {
        $where = 'CONCAT(posY,"-",posX)';
        $params = $this->db->getParams();
        $isSQLite = $params['driver'] === 'pdo_sqlite';

        if ($isSQLite) {
            $where = '(posY||"-"||posX)';
        }
        $result = $this->getQueryBuilder()->where(
            $where . ' IN (\'' . implode("','", array_keys($area)) . '\')'
        )->execute();
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $found = array();
        if (count($rows) < 0) {
            return $found;
        }
        foreach ($rows as $row) {
            $entity = $this->rowToEntity($row);
            $found[$entity->getCityId()] = $entity;
            $this->replace($entity);
        }
        return $found;
    }

    public function getLastCreatedCity()
    {
        $result = $this->getQueryBuilder()
            ->orderBy('c.cityId', 'DESC')->execute();
        $row = $result->fetch(PDO::FETCH_OBJ);
        if (!$row) {
            return null;
        }
        $entity = $this->rowToEntity($row);
        $this->replace($entity);
        return $entity;
    }
}
