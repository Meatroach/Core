<?php

namespace OpenTribes\Core\Domain\Service;

/**
 *
 * @author BlackScorp<witalimik@web.de>
 */
interface PasswordHasher {
    /**
     * @return string Hassed Password
     */
    public function hash($rawPassword);
    /**
     * @return true|false verify password 
     */
    public function verify($hash, $rawPassword);
}
