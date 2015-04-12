<?php

namespace OpenTribes\Core\Test\DataProvider;


class LoginDataProvider {
    public function failingData()
    {
        return array(
            'empty username' => array('', '123456', 'Invalid login'),
            'short username' => array('tes', '123456', 'Invalid login'),
            'long username' => array(str_repeat('s', 25), '123456', 'Invalid login'),
            'invalid username' => array('BläckScörp', '123456', 'Username contains invalid character'),
            'empty password' => array('Test', '', 'Invalid login'),
            'short password' => array('Test', '12345', 'Invalid login'),
            'invalid login' => array('Test', 'testtest', 'Invalid login')
        );
    }
}