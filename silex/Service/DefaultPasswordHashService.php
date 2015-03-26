<?php

namespace OpenTribes\Core\Silex\Service;


use OpenTribes\Core\Service\PasswordHashService;

class DefaultPasswordHashService implements PasswordHashService
{
    /**
     * @param $rawPassword
     * @return string
     */
    public function hash($rawPassword)
    {
       return password_hash($rawPassword,PASSWORD_DEFAULT);
    }

    /**
     * @param $hash
     * @param $rawPassword
     * @return bool
     */
    public function verify($rawPassword, $hash)
    {
        return password_verify($rawPassword,$hash);
    }

}