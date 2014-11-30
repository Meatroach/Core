<?php

namespace OpenTribes\Core\Validator;

use OpenTribes\Core\Traits\ErrorTrait;

/**
 * Description of Validator
 *
 * @author BlackScorp<witalimik@web.de>
 */
abstract class Validator
{
    use ErrorTrait;


    public function isValid()
    {
        $this->validate();
        return false === $this->hasErrors();
    }

    abstract protected function validate();
}
