<?php
namespace OpenTribes\Core\Mock\Message;

use OpenTribes\Core\Message;
use OpenTribes\Core\Message\Repository as MessageRepositoryInterface;

class Repository implements MessageRepositoryInterface{
    private $messages = array();
 
    public function add(Message $message) {
        $this->messages[] = $message;
    }
    public function findAll() {
        return $this->messages;
    }
}