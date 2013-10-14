<?php

namespace OpenTribes\Core;

abstract class Validator{
    private $errors;
    public function getErrors(){
        return $this->errors;
    }
    abstract public function isValid();
}
