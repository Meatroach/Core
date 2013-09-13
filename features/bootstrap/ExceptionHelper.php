<?php

class ExceptionHelper {

    private $exceptions = array(
        'username not exists' => 'OpenTribes\Core\User\Login\Exception\NotExists',
        'account is not active' => 'OpenTribes\Core\User\Login\exception\NotActive',
        'invalid login informations' => 'OpenTribes\Core\User\Login\exception\Invalid',
        'username is empty' => 'OpenTribes\Core\User\exception\Username\Emptyexception',
        'username is too short' => 'OpenTribes\Core\User\exception\Username\Short',
        'username is too long' => 'OpenTribes\Core\User\exception\Username\Long',
        'username has invalid character' => 'OpenTribes\Core\User\exception\Username\Invalid',
        'username already exists' => 'OpenTribes\Core\User\Create\exception\Username\Exists',
        'email is empty' => 'OpenTribes\Core\User\exception\Email\Emptyexception',
        'email already exists' => 'OpenTribes\Core\User\Create\exception\Email\Exists',
        'email is invalid' => 'OpenTribes\Core\User\exception\Email\Invalid',
        'password is empty' => 'OpenTribes\Core\User\exception\Password\Emptyexception',
        'password is too short' => 'OpenTribes\Core\User\exception\Password\Short',
        'password confirm does not match the password' => 'OpenTribes\Core\User\Create\exception\Password\Confirm',
        'email confirm does not match the email' => 'OpenTribes\Core\User\Create\exception\Email\Confirm',
        'activation code is invalid'=>'OpenTribes\Core\User\Activate\exception\Invalid',
        'account already active'=>'OpenTribes\Core\User\Activate\exception\Active',
        'account not exists'=>'OpenTribes\Core\User\Activate\exception\NotExists',
        'tile not accessable'=>'OpenTribes\Core\City\Create\Exception\NotAccessable',
        'city found at location'=>'OpenTribes\Core\City\Create\Exception\Exists'
    );
    private $exception;
    private function map($key) {
       return isset($this->exceptions[$key]) ?  $this->exceptions[$key] : null;
    }
    public function setException(\Exception $exception){
        $this->exception = $exception;
    }
      /**
     * Assert a specific exception
     * @param String $exception Exception name
     */
    public function assertException($exception) {
        $instance = $this->map($exception);
        assertNotNull($this->exception);
        assertNotNull($instance);
        assertInstanceOf($instance, $this->exception);
    }
}