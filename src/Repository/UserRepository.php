<?php

namespace OpenTribes\Core\Repository;


use OpenTribes\Core\Entity\UserEntity;

interface UserRepository {
    /**
     * @param $username
     * @return UserEntity | null
     */
    public function findByUsername($username);

    /**
     * @param $email
     * @return UserEntity | null
     */
    public function findByEmail($email);
    public function getUniqueId();

    /**
     * @param $userId
     * @param $username
     * @param $passwordHash
     * @param $email
     * @return UserEntity
     */
    public function create($userId, $username, $passwordHash, $email);
    public function add(UserEntity $user);
} 