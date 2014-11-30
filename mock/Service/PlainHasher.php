<?php

namespace OpenTribes\Core\Mock\Service;

use OpenTribes\Core\Service\PasswordHasher;

/**
 * Description of PlainHash
 *
 * @author BlackScorp<witalimik@web.de>
 */
class PlainHasher implements PasswordHasher
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
