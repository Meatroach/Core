<?php

namespace OpenTribes\Core;

abstract class Validator{
    protected $errors;
    protected $validationObject;
    public function getErrors(){
        return $this->errors;
    }
    public function getValidationObject(){
        return $this->validationObject;
    }

    abstract public function isValid();
}
