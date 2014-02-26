<?php

namespace OpenTribes\Core\Domain\Validator;

/**
 * Description of Validator
 *
 * @author BlackScorp<witalimik@web.de>
 */
abstract class Validator {

    private $errors = array();

    public function isValid() {
        $this->validate();
    }

    public function getErrors() {
        return $this->errors;
    }

    protected function attachError($error, $key = null) {
        if ($key) {
            $this->errors[$key] = $error;
        } else {
            $this->errors[] = $error;
        }
    }

    public function hasErrors() {
        return count($this->errors) > 0;
    }

    abstract function validate();
}
