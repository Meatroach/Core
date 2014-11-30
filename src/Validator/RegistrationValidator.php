<?php

namespace OpenTribes\Core\Validator;


abstract class RegistrationValidator extends Validator{
    public $username = '';
    public $password = '';
    public $passwordConfirm = '';
    public $email = '';
    public $emailConfirm = '';
    public $acceptedTerms = '';
    public $usernameExists = true;
    public $emailExists = true;

}