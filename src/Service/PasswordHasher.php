<?php

namespace OpenTribes\Core\Service;

/**
 *
 * @author BlackScorp<witalimik@web.de>
 */
interface PasswordHasher
{
    /**
     * @return string Hassed Password
     */
    public function hash($rawPassword);

    /**
     * @param string $hash
     * @return boolean verify password
     */
    public function verify($hash, $rawPassword);
}
