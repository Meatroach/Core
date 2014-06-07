<?php

namespace OpenTribes\Core\Mock\Service;

use OpenTribes\Core\Service\PasswordHasher;

/**
 * Description of PlainHash
 *
 * @author BlackScorp<witalimik@web.de>
 */
class PlainHash implements PasswordHasher
{
    public function hash($rawPassword)
    {
        return $rawPassword;
    }

    public function verify($hash, $rawPassword)
    {
        return $hash === $rawPassword;
    }

}
