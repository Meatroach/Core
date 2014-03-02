<?php

namespace OpenTribes\Core\Domain\Response;

/**
 * Description of Registration
 *
 * @author BlackScorp<witalimik@web.de>
 */
class Registration extends Response{
    public $username;
    public $email;
    public $emailConfirm;
    public $password;
    public $passwordConfirm;
    public $activationCode;
    public $termsAndConditions;

}
