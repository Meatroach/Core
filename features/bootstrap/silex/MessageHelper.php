<?php
use Behat\Mink\Mink;
class DeliveryMessageHelper extends MessageHelper{
    private $mink;
    public function __construct(Mink $mink) {
        $this->mink = $mink;
    }

    public function hasMessage($expectedMessage) {
        $this->mink->assertSession()->pageTextContains($expectedMessage);
    }
}