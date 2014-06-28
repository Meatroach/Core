<?php

namespace OpenTribes\Core\Repository;

use OpenTribes\Core\Entity\User as UserEntity;

/**
 *
 * @author BlackScorpx
 */
interface User
{

    /**
     * @param integer $userId UserId
     * @param string $username username
     * @param string $password password hash
     * @param string $email email adress
     * @return UserEntity
     */
    public function create($userId, $username, $password, $email);

    /**
     * @return integer
     */
    public function getUniqueId();

    /**
     * @param UserEntity $user
     * @return void
     */
    public function add(UserEntity $user);

    /**
     * @param UserEntity $user
     * @return void
     */
    public function replace(UserEntity $user);

    /**
     * @param UserEntity $user
     * @return void
     */
    public function delete(UserEntity $user);

    /**
     * Sync Repository with Entity Source
     * @return void
     */
    public function sync();

    /**
     * @param string $email
     * @return UserEntity|null
     */
    public function findOneByEmail($email);

    /**
     * @param string $username
     * @return UserEntity|null
     */
    public function findOneByUsername($username);

    /**
     * @return null|integer
     */
    public function flush();
}
