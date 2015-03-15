<?php

namespace OpenTribes\Core\Silex\Repository;


use OpenTribes\Core\Entity\UserEntity;
use OpenTribes\Core\Repository\UserRepository;
use PDO;

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
        $sql = "SELECT * FROM users WHERE username = :username";
        $statement = $this->connection->prepare($sql);
        $statement->execute([':username'=>$username]);
        $result = $statement->fetchAll(PDO::FETCH_OBJ);

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
        $countUsers = count($this->users);
        $countUsers++;
       return $countUsers;
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

    public function add(UserEntity $user)
    {
        $this->users[$user->getUserId()] = $user;

    }

    public function sync()
    {
        // TODO: Implement sync() method.
    }
    private function getQueryBuilder(){

    }
}