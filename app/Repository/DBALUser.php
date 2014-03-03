<?php

namespace OpenTribes\Core\Repository;

use OpenTribes\Core\Domain\Entity\User as UserEntity;
use OpenTribes\Core\Domain\Repository\User as UserRepositoryInterface;
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
        $this->users[$user->getId()] = $user;
        $this->added[$user->getId()] = $user->getId();
    }

    public function create($id, $username, $password, $email) {
        return new UserEntity($id, $username, $password, $email);
    }

    public function delete(UserEntity $user) {
        unset($this->users[$user->getId()]);
        $this->deleted[$user->getId()] = $user->getId();
    }

    public function findOneByEmail($email) {
        $queryBuilder = $this->db->createQueryBuilder();
        $result       = $queryBuilder->select('u.id')->from('users', 'u')->where('u.email = :email')->setParameter(':email', $email)->execute();
        //$user = $this->db->executeQuery("SELECT 1 FROM users WHERE email = :email");
    }

    public function findOneByUsername($username) {
        $queryBuilder = $this->db->createQueryBuilder();
        $result       = $queryBuilder->select('u.id', 'u.username', 'u.password', 'u.email')->from('users', 'u')
                ->where('u.username = :username')
                ->setParameter(':username', $username)
                ->execute();
        $row          = $result->fetch(\PDO::FETCH_OBJ);
        $entity       = $this->rowToEntity($row);
        $this->replace($entity);
        return $entity;
    }

    public function getUniqueId() {
        return 1;
    }

    public function replace(UserEntity $user) {
        $this->users[$user->getId()]    = $user;
        $this->modified[$user->getId()] = $user->getId();
    }

    private function rowToEntity($row) {
        return $this->create($row->id, $row->username, $row->password, $row->email);
    }

    private function entityToRow(UserEntity $user) {
        return array(
            'id'       => $user->getId(),
            'username' => $user->getUsername(),
            'email'    => $user->getEmail(),
            'password' => $user->getPassword()
        );
    }

    public function sync() {
        foreach ($this->added as $id) {
            if (isset($this->users[$id])) {
                $user = $this->users[$id];
                $this->db->insert('users', $this->entityToRow($user));
            }
        }
    }

}
