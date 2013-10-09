<?php

namespace OpenTribes\Core\Message;
use OpenTribes\Core\Message;
interface Repository{
public function add(Message $message);
public function findAll();

}
