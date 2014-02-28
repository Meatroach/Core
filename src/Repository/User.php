<?php

namespace OpenTribes\Core\Domain\Repository;

use OpenTribes\Core\Domain\Entity\User as UserEntity;

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

    public function add(UserEntity $user);

    public function replace(UserEntity $user);

    public function delete(UserEntity $user);
    /**
     * Sync Repository with Entity Source
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
}
