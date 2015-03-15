<?php

namespace OpenTribes\Core\Response;


interface ErrorResponse{
    public function setErrors(array $errors);
    public function hasErrors();
    public function addError($error);
    public function getErrors();
} 