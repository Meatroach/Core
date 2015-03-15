<?php

namespace OpenTribes\Core\Test\DataProvider;


class RegistrationDataProvider {
    public function failingData()
    {
        return array(
            'short username'=>array('Us','123456','123456','test@foo.bar','test@foo.bar',true,'Username is too short'),
            'long username'=>array(str_repeat('u', 25),'123456','123456','test@foo.bar','test@foo.bar',true,'Username is too long'),
            'invalid username'=>array('BläckScörp','123456','123456','test@foo.bar','test@foo.bar',true,'Username contains invalid character'),
            'empty username'=> array('','123456','123456','test@foo.bar','test@foo.bar',true,'Username is empty'),
            'username exists'=>array('Dummy','123456','123456','test@foo.bar','test@foo.bar',true,'Username exists'),
            'password too short'=>array('BlackScorp','123','123456','test@foo.bar','test@foo.bar',true,'Password is too short'),
            'password confirm not match'=>array('BlackScorp','123456','654321','test@foo.bar','test@foo.bar',true,'Password confirm not match'),
            'password is empty'=>array('BlackScorp','','','test@foo.bar','test@foo.bar',true,'Password is empty'),
            'empty email'=>array('BlackScorp','123456','123456','','',true,'Email is empty'),
            'invalid email'=>array('BlackScorp','123456','123456','test@foo','test@foo',true,'Email is invalid'),
            'email confirm not match'=>array('BlackScorp','123456','123456','test@foo.bar','test@foo',true,'Email confirm not match'),
            'email exists'=>array('BlackScorp','123456','123456','dummy@test.com','dummy@test.com',true,'Email exists'),
            'accept terms'=>array('BlackScorp','123456','123456','test@foo.bar','test@foo.bar',false,'Terms and Conditions are not accepted'),
        );
    }
}