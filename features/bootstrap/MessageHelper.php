<?php

class MessageHelper{
    private $messages;
    public function setMessages(array $messages){
        $this->messages = $messages;
    }
    public function hasMessage($expectedMessage){
        
        foreach($this->messages as $currentMessage){
            if($currentMessage === $expectedMessage) return true;
        }
        return false;
    }
    public function checkMessage($message){
        assertTrue($this->hasMessage($message));
    }
}
