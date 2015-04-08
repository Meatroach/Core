<?php

namespace OpenTribes\Core\View;


use OpenTribes\Core\Entity\DirectionEntity;

class DirectionView {
    public $isSelected = false;
    public $name = '';
    public function __construct(DirectionEntity $direction){
        $this->name = $direction->getName();
    }
    public function select(){
        $this->isSelected = true;
    }
}