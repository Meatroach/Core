<?php

namespace OpenTribes\Core\Mock\Service;

use OpenTribes\Core\Service\CodeGenerator as GeneratorInterface;

class QwertyGenerator implements GeneratorInterface {

    public function create() {
        return 'qwerty';
    }

}
