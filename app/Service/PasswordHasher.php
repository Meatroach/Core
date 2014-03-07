<?php

namespace OpenTribes\Core\Service;
use OpenTribes\Core\Domain\Service\PasswordHasher as PasswordHasherInterface;
/**
 * Description of PasswordHasher
 *
 * @author BlackScorp<witalimik@web.de>
 */
class PasswordHasher implements PasswordHasherInterface{
    public function hash($rawPassword) {
        return password_hash($rawPassword, PASSWORD_DEFAULT);
    }

    public function verify($hash, $rawPassword) {
        return password_verify($rawPassword, $hash);
    }

}
