<?php

namespace OpenTribes\Core\Mock\Service;

use OpenTribes\Core\Service\ActivationCodeGenerator;

/**
 * Description of TestGenerator
 *
 * @author BlackScorp<witalimik@web.de>
 */
class TestGenerator implements ActivationCodeGenerator {

    public function create() {
        return 'test';
    }

}
