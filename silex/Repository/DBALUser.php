<?php

namespace OpenTribes\Core\Silex\Repository;

use Doctrine\DBAL\Connection;
use OpenTribes\Core\Entity\User as UserEntity;
use OpenTribes\Core\Repository\User as UserRepositoryInterface;

/**
 * Description of DBALUser
 *
 * @author BlackScorp<witalimik@web.de>
 */
class DBALUser extends Repository implements UserRepositoryInterface
{

    /**
     * @var Connection
     */
    private $db;

    /**
     * @var UserEntity[]
     */
    private $users = array();
    private $dateFormat = 'Y-m-d H:i:s';

    /**
     * @param Connection $db DBAL Connection
     */
    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    /**
     * {@inheritDoc}
     */
    public function add(UserEntity $user)
    {
        $id               = $user->getId();
        $this->users[$id] = $user;
        parent::markAdded($id);
    }

    /**
     * {@inheritDoc}
     */
    public function create($id, $username, $password, $email)
    {
        return new UserEntity((int)$id, $username, $password, $email);
    }

    /**
     * {@inheritDoc}
     */
    public function delete(UserEntity $user)
    {
        $id = $user->getId();
        parent::markDeleted($id);
    }

    /**
     * {@inheritDoc}
     */
    public function findOneByEmail($email)
    {
        foreach ($this->users as $user) {
            if ($user->getEmail() === $email) {
                return $user;
            }
        }
        $result = $this->getQueryBuilder()
            ->where('u.email = :email')
            ->setParameter(':email', $email)
            ->execute();
        $row    = $result->fetch(\PDO::FETCH_OBJ);

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
    public function findOneByUsername($username)
    {

        foreach ($this->users as $user) {
            if ($user->getUsername() === $username) {
                return $user;
            }
        }

        $result = $this->getQueryBuilder()
            ->where('u.username = :username')
            ->setParameter(':username', $username)
            ->execute();

        $row = $result->fetch(\PDO::FETCH_OBJ);

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
    public function getUniqueId()
    {
        $result = $this->db->prepare("SELECT MAX(id) FROM users");
        $result->execute();
        $row = $result->fetchColumn();
        $row += count($this->users);
        $row -= count(parent::getDeleted());
        return (int)($row + 1);
    }

    /**
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    private function getQueryBuilder()
    {
        $queryBuilder = $this->db->createQueryBuilder();
        return $queryBuilder->select(
            'u.id',
            'u.username',
            'u.password',
            'u.email',
            'u.activationCode',
            'u.lastLogin',
            'u.registered',
            'u.lastAction'
        )->from('users', 'u');
    }

    /**
     * {@inheritDoc}
     */
    public function replace(UserEntity $user)
    {
        $id               = $user->getId();
        $this->users[$id] = $user;
        parent::markModified($id);
    }

    private function rowToEntity($row)
    {
        $lastLogin        = \DateTime::createFromFormat($this->dateFormat, $row->lastLogin);
        $registrationDate = \DateTime::createFromFormat($this->dateFormat, $row->registered);
        $lastAction       = \DateTime::createFromFormat($this->dateFormat, $row->lastAction);
        $user             = $this->create($row->id, $row->username, $row->password, $row->email);
        if ($lastAction) {
            $user->setLastAction($lastAction);
        }
        if ($lastLogin) {
            $user->setLastLogin($lastLogin);
        }
        if ($registrationDate) {
            $user->setRegistrationDate($registrationDate);
        }

        $user->setActivationCode($row->activationCode);
        return $user;
    }

    private function entityToRow(UserEntity $user)
    {


        $data = array(
            'id'             => $user->getId(),
            'username'       => $user->getUsername(),
            'email'          => $user->getEmail(),
            'password'       => $user->getPassword(),
            'activationCode' => $user->getActivationCode()
        );
        if ($user->getRegistrationDate() instanceof \DateTime) {
            $data['registered'] = $user->getRegistrationDate()->format($this->dateFormat);
        }
        if ($user->getLastLogin() instanceof \DateTime) {
            $data['lastLogin'] = $user->getLastLogin()->format($this->dateFormat);

        }
        if ($user->getLastAction() instanceof \DateTime) {
            $data['lastAction'] = $user->getLastAction()->format($this->dateFormat);
        }
        return $data;
    }

    /**
     * {@inheritDoc}
     */
    public function sync()
    {
        foreach (parent::getDeleted() as $id) {
            if (isset($this->users[$id])) {
                $this->db->delete('users', array('id' => $id));
                unset($this->users[$id]);
                parent::reassign($id);
            }
        }

        foreach (parent::getAdded() as $id) {
            if (isset($this->users[$id])) {
                $user = $this->users[$id];
                $this->db->insert('users', $this->entityToRow($user));
                parent::reassign($id);
            }
        }
        foreach (parent::getModified() as $id) {
            if (isset($this->users[$id])) {
                $user = $this->users[$id];
                $this->db->update('users', $this->entityToRow($user), array('id' => $id));
                parent::reassign($id);
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function flush()
    {
        return $this->db->exec("DELETE FROM users");
    }

}
