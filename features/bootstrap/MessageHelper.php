<?php
use PHPUnit_Framework_Assert as Test;

class MessageHelper
{
    private $messages;

    public function setMessages(array $messages)
    {
        $this->messages = $messages;
    }

    public function hasMessage($expectedMessage)
    {
        Test::assertTrue(
            in_array($expectedMessage, $this->messages),
            sprintf('"%s" Message not found', $expectedMessage)
        );

    }

}
