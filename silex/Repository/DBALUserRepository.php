<?php

namespace OpenTribes\Core\Silex\Repository;


use OpenTribes\Core\Entity\UserEntity;
use OpenTribes\Core\Repository\UserRepository;
use PDO;
use stdClass;

class DBALUserRepository extends DBALRepository implements UserRepository,WritableRepository
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
        foreach($this->users as $user){
            if($user->getUsername() === $username){
                return $user;
            }
        }
        $sql = $this->getSql();
        $sql.= ' WHERE username = :username';

        $statement = $this->connection->prepare($sql);
        $statement->execute([':username'=>$username]);
        $result = $statement->fetch(PDO::FETCH_OBJ);
        if(!$result){
            return null;
        }
        $user = $this->rowToEntity($result);
        return $user;
    }

    /**
     * @param $email
     * @return UserEntity | null
     */
    public function findByEmail($email)
    {
        foreach($this->users as $user){
            if($user->getEmail() === $email){
                return $user;
            }
        }
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
       $userEntity = new UserEntity($userId,$username,$passwordHash,$email);
        return $userEntity;
    }
    public function delete(UserEntity $user){
        $id = $user->getUserId();
        $this->markAsDeleted($id);
    }
    public function add(UserEntity $user)
    {
        $id = $user->getUserId();
        $this->users[$id] = $user;
        $this->markAsAdded($id);
    }

    public function sync()
    {
        foreach($this->getDeleted() as $deletedId){
            $this->connection->delete('users',['userId' => $deletedId]);
        }

        foreach($this->getAdded() as $addedId){
            if(!isset($this->users[$addedId])){continue;}
            $userEntity = $this->users[$addedId];
            $this->connection->insert('users',$this->entityToRow($userEntity));
        }



        $this->users = [];
    }
    private function entityToRow(UserEntity $entity){
        $row = [
            'userId' => $entity->getUserId(),
            'username' => $entity->getUsername(),
            'password' => $entity->getPasswordHash(),
            'email' => $entity->getEmail()
        ];
        return $row;
    }
    private function rowToEntity(stdClass $row){
        $userEntity = new UserEntity($row->userId,$row->username,$row->password,$row->email);
        return $userEntity;
    }
    private function getSql(){
        $sql = "SELECT userId,username,password,email FROM users";
        return $sql;
    }
}