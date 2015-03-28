<?php

namespace OpenTribes\Core\Silex\Repository;


use OpenTribes\Core\Entity\UserEntity;
use OpenTribes\Core\Repository\UserRepository;
use PDO;
use stdClass;
use DateTime;

class DBALUserRepository extends DBALRepository implements UserRepository, WritableRepository
{
    /**
     * @var UserEntity[]
     */
    private $users = [];

    /**
     * @param $username
     * @return UserEntity | null
     */
    public function findByUsername($username)
    {
        foreach ($this->users as $user) {
            if ($user->getUsername() === $username) {
                return $user;
            }
        }
        $sql = $this->getSql();
        $sql .= ' WHERE username = :username';

        $parameters = [':username' => $username];
        return $this->loadOne($sql, $parameters);
    }

    /**
     * @param $email
     * @return UserEntity | null
     */
    public function findByEmail($email)
    {
        foreach ($this->users as $user) {
            if ($user->getEmail() === $email) {
                return $user;
            }
        }
        $sql = $this->getSql();
        $sql .= ' WHERE email = :email';
        $parameters = [':email' => $email];
        return $this->loadOne($sql, $parameters);
    }

    public function getUniqueId()
    {
        $result = $this->connection->prepare("SELECT MAX(userId) FROM users");
        $result->execute();
        $row = $result->fetchColumn();
        $row += count($this->users);
        return (int)($row + 1);
    }

    /**
     * @param $userId
     * @param $username
     * @param $passwordHash
     * @param $email
     * @return UserEntity
     */
    public function create($userId, $username, $passwordHash, $email)
    {
        $userEntity = new UserEntity($userId, $username, $passwordHash, $email);
        return $userEntity;
    }

    public function delete(UserEntity $user)
    {
        $id = $user->getUserId();
        $this->markAsDeleted($id);
    }

    public function add(UserEntity $user)
    {
        $id = $user->getUserId();
        $this->users[$id] = $user;
        $this->markAsAdded($id);
    }

    public function modify(UserEntity $user)
    {
        $id = $user->getUserId();
        $this->users[$id] = $user;
        $this->markAsModified($id);
    }

    private function deleteUsers()
    {
        foreach ($this->getDeleted() as $deletedId) {
            $this->connection->delete('users', ['userId' => $deletedId]);
            $this->reset($deletedId);
        }
    }

    private function addUsers()
    {
        foreach ($this->getAdded() as $addedId) {
            if (!isset($this->users[$addedId])) {
                continue;
            }
            $userEntity = $this->users[$addedId];
            $userEntity->setRegistrationDate(new DateTime());
            $userEntity->setLastAction(new DateTime());
            $this->connection->insert('users', $this->entityToRow($userEntity));
            $this->reset($addedId);
        }
    }

    private function modifyUsers()
    {
        foreach ($this->getModified() as $modifiedId) {
            if (!isset($this->users[$modifiedId])) {
                continue;
            }
            $userEntity = $this->users[$modifiedId];
            $userEntity->setLastAction(new DateTime());
            $this->connection->update('users', $this->entityToRow($userEntity), ['userId' => $modifiedId]);
            $this->reset($modifiedId);
        }
    }

    public function sync()
    {
        $this->deleteUsers();
        $this->addUsers();
        $this->modifyUsers();
        $this->users = [];
    }

    public function truncate()
    {
        $this->connection->query('TRUNCATE TABLE users');
    }

    private function entityToRow(UserEntity $entity)
    {
        $row = [
            'userId' => $entity->getUserId(),
            'username' => $entity->getUsername(),
            'password' => $entity->getPasswordHash(),
            'email' => $entity->getEmail(),
            'registered' => $entity->getRegistrationDate()->format('Y-m-d H:i:s')
        ];
        if ($entity->getLastAction()) {
            $row['lastAction'] = $entity->getLastAction()->format('Y-m-d H:i:s');
        }
        return $row;
    }

    private function rowToEntity(stdClass $row)
    {
        $userEntity = new UserEntity((int)$row->userId, $row->username, $row->password, $row->email);
        $registrationDate = DateTime::createFromFormat('Y-m-d H:i:s', $row->registered);
        if ($registrationDate) {
            $userEntity->setRegistrationDate($registrationDate);
        }
        $userEntity->setLastAction(new DateTime());
        return $userEntity;
    }

    private function getSql()
    {
        $sql = "SELECT userId,username,password,email,registered,lastAction,lastLogin FROM users";
        return $sql;
    }

    /**
     * @param $sql
     * @param $parameters
     * @return null|UserEntity
     * @throws \Doctrine\DBAL\DBALException
     */
    private function loadOne($sql, $parameters)
    {
        $statement = $this->connection->prepare($sql);
        $statement->execute($parameters);
        $this->logger->info("Executing SQL query", ['query' => $sql, 'parameters' => $parameters]);
        $result = $statement->fetch(PDO::FETCH_OBJ);
        if (!$result) {
            return null;
        }
        $user = $this->rowToEntity($result);
        $this->modify($user);
        return $user;
    }
}