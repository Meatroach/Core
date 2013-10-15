<?php
namespace OpenTribes\Core\Guest\Account;

class Request{
    protected $username;
    protected $password;
    protected $passwordConfirm;
    protected $email;
    protected $emailConfirm;
    protected $termsAndConditions;
    protected $rolename;
    public function __construct($username,$password,$passwordConfirm,$email,$emailConfirm,$termsAndConditions,$rolename) {
        $this->setUsername($username)
                ->setEmail($email)
                ->setEmailConfirm($emailConfirm)
                ->setPassword($password)
                ->setPasswordConfirm($passwordConfirm)
                ->setTermsAndConditions($termsAndConditions)
                ->setRolename($rolename);
        return $this;
    }
    public function setRolename($rolename){
        $this->rolename = $rolename;
        return $this;
    }

    public function setUsername($username){
        $this->username = $username;
        return $this;
    }
    public function setPassword($password){
        $this->password = $password;
        return $this;
    }
    public function setPasswordConfirm($passwordConfirm){
        $this->passwordConfirm = $passwordConfirm;
        return $this;
    }
    public function setEmail($email){
        $this->email = $email;
        return $this;
    }
    public function setEmailConfirm($emailConfirm){
        $this->emailConfirm = $emailConfirm;
        return $this;
    }
    public function setTermsAndConditions($termsAndConditions){
        $this->termsAndConditions = $termsAndConditions;
        return $this;
    }
    public function getUsername(){
        return $this->username;
    }
    public function getPassword(){
        return $this->password;
    }
    public function getPasswordConfirm(){
        return $this->passwordConfirm;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getEmailConfirm(){
        return $this->emailConfirm;
    }
    public function getTermsAndConditions(){
        return $this->termsAndConditions;
    }
    public function getRolename(){
        return $this->rolename;
    }
}
