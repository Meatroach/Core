<?php

namespace OpenTribes\Core\Validator;


abstract class LoginValidator extends Validator{
    public $username = '';
    public $password = '';
    public $verified = false;
} 