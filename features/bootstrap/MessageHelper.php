<?php
require_once 'vendor/phpunit/phpunit/PHPUnit/Framework/Assert/Functions.php';
class MessageHelper{
    private $messages;
    public function setMessages(array $messages){
        $this->messages = $messages;
    }
    public function hasMessage($expectedMessage){
        assertTrue(in_array($expectedMessage, $this->messages));
    
    }
 
}
