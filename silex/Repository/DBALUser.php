<?php

namespace OpenTribes\Core\Silex\Repository;

use OpenTribes\Core\Entity\User as UserEntity;
use OpenTribes\Core\Repository\User as UserRepositoryInterface;
use Doctrine\DBAL\Connection;

/**
 * Description of DBALUser
 *
 * @author BlackScorp<witalimik@web.de>
 */
class DBALUser implements UserRepositoryInterface {

    private $db;

    /**
     * @var UserEntity[]
     */
    private $users    = array();
    private $added    = array();
    private $modified = array();
    private $deleted  = array();

    public function __construct(Connection $db) {
        $this->db = $db;
    }

    public function add(UserEntity $user) {
        $id = $user->getId();

        $this->reassign($id);
        $this->users[$id] = $user;
        $this->added[$id] = $id;
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

    public function create($id, $username, $password, $email) {
        return new UserEntity((int) $id, $username, $password, $email);
    }

    public function delete(UserEntity $user) {
        $id                 = $user->getId();
        $this->reassign($id);
        $this->deleted[$id] = $id;
    }

    public function findOneByEmail($email) {
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

    public function findOneByUsername($username) {

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

    public function getUniqueId() {
        $result = $this->db->prepare("SELECT MAX(id) FROM users");
        $result->execute();
        $row    = $result->fetchColumn();
        $row += count($this->users);
        $row -= count($this->deleted);

        return $row + 1;
    }

    private function getQueryBuilder() {
        $queryBuilder = $this->db->createQueryBuilder();
        return $queryBuilder->select('u.id', 'u.username', 'u.password', 'u.email', 'u.activationCode')->from('users', 'u');
    }

    public function replace(UserEntity $user) {
        $id                  = $user->getId();
        $this->reassign($id);
        $this->users[$id]    = $user;
        $this->modified[$id] = $id;
    }

    private function rowToEntity($row) {
        $user = $this->create($row->id, $row->username, $row->password, $row->email);
        $user->setActivationCode($row->activationCode);
        return $user;
    }

    private function entityToRow(UserEntity $user) {
        return array(
            'id'             => $user->getId(),
            'username'       => $user->getUsername(),
            'email'          => $user->getEmail(),
            'password'       => $user->getPassword(),
            'activationCode' => $user->getActivationCode()
        );
    }

    public function sync() {
        foreach ($this->deleted as $id) {
            
            if (isset($this->users[$id])) {
                $user = $this->users[$id];
                $this->db->delete('users', array('id' => $id));
                $this->users[$id] = null;
                $this->reassign($id);
            }
        }

        foreach ($this->added as $id) {
            if (isset($this->users[$id])) {
                $user = $this->users[$id];
                $this->db->insert('users', $this->entityToRow($user));
                $this->reassign($id);
            }
        }
        foreach ($this->modified as $id) {
            if (isset($this->users[$id])) {
                $user = $this->users[$id];
                $this->db->update('users', $this->entityToRow($user), array('id' => $id));
                $this->reassign($id);
            }
        }
    }

    public function flush() {
        return $this->db->exec("DELETE FROM users");
    }

}
