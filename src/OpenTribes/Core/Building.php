<?php
namespace OpenTribes\Core;

class Building extends Entity{
    private $minimumLevel;
    private $maximumLevel;
    public function setMinimumLevel($level){
        $this->minimumLevel = (int) $level;
        return $this;
    }
    public function setMaximumLevel($level){
        $this->maximumLevel = (int) $level;
        return $this;
    }
    public function getMaximumLevel(){
        return $this->maximumLevel;
    }
    public function getMinimumLevel(){
        return $this->minimumLevel;
    }
}
