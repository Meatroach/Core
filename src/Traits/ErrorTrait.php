<?php

namespace OpenTribes\Core\Traits;


trait ErrorTrait {
    private $errors = array();

    public function setErrors(array $errors)
    {
        $this->errors = $errors;
    }
    public function getErrors()
    {
        return $this->errors;
    }
    public function addError($errorMessage)
    {
        $this->errors[]=$errorMessage;
    }
    public function hasErrors()
    {
        return count($this->errors) > 0;
    }
} 