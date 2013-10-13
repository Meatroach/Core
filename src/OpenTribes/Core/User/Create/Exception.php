<?php

namespace OpenTribes\Core\User\Create;

class Exception extends \Exception{
    private $messages = array();
    public function __construct($message = null, $code = null, $previous = null) {
        parent::__construct($message, $code, $previous);
    }
    public function setMessages(array $messages){
        $this->messages = $messages;
        return $this;
    }

    public function getMessages(){
        return $this->messages;
    }
}
