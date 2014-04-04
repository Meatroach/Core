<?php

namespace OpenTribes\Core\Repository;

use OpenTribes\Core\Entity\User as UserEntity;

/**
 *
 * @author BlackScorpx
 */
interface User {

    /**
     * @return UserEntity
     */
    public function create($id, $username, $password, $email);

    /**
     * @return \integer 
     */
    public function getUniqueId();

    /**
     * @return void
     */
    public function add(UserEntity $user);

    /**
     * @return void
     */
    public function replace(UserEntity $user);

    /**
     * @return void
     */
    public function delete(UserEntity $user);
    /**
     * Sync Repository with Entity Source
     * @return void
     */
    public function sync();
    /**
     * @return UserEntity|null
     */
    public function findOneByEmail($email);
    /**
     * @return UserEntity|null
     */
    public function findOneByUsername($username);

    /**
     * @return null|integer
     */
    public function flush();
}
