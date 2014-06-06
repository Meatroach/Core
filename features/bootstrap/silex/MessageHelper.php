<?php
use Behat\Mink\Mink;

class SilexMessageHelper extends MessageHelper
{
    private $mink;

    public function __construct(Mink $mink)
    {
        $this->mink = $mink;
    }

    public function hasMessage($expectedMessage)
    {
        $this->mink->assertSession()->pageTextContains($expectedMessage);
    }
}