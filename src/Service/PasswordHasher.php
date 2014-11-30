<?php

namespace OpenTribes\Core\Service;

/**
 *
 * @author BlackScorp<witalimik@web.de>
 */
interface PasswordHasher
{
    /**
     * @param $rawPassword
     * @return string
     */
    public function hash($rawPassword);

    /**
     * @param $hash
     * @param $rawPassword
     * @return bool
     */
    public function verify($rawPassword,$hash);
}
