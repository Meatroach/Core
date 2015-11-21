<?php

namespace OpenTribes\Core\Test\Mock\Service;

use OpenTribes\Core\Service\PasswordHashService;

/**
 * Description of PlainHash
 *
 * @author BlackScorp<witalimik@web.de>
 */
class PlainHashService implements PasswordHashService
{
    public function hash($rawPassword)
    {
        return $rawPassword;
    }

    public function verify($rawPassword,$hash)
    {
        return $hash === $rawPassword;
    }
}
