<?php

namespace OpenTribes\Core\Domain\ValidationDto;

/**
 * Description of Registration
 *
 * @author BlackScorp<witalimik@web.de>
 */
class Registration {
    public $username;
    public $password;
    public $passwordConfirm;
    public $email;
    public $emailConfirm;
    public $termsAndConditions;
    public $isUniqueUsername;
    public $isUniqueEmail;

}
