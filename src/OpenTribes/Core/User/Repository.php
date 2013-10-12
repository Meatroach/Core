<?php

namespace OpenTribes\Core\User;

use OpenTribes\Core\User;
use OpenTribes\Core\Message\Repository as MessageRepository;
interface Repository {
 
    public function findByUsername($username);
    public function findByEmail($email);
    public function add(User $user);
    public function create(MessageRepository $messageRepository);
    public function emailExists($email);
    public function usernameExists($username);
    public function getUniqueId();
}