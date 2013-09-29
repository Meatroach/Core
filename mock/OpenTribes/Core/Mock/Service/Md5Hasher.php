<?php

namespace OpenTribes\Core\Mock\Service;

use OpenTribes\Core\Service\Hasher as HasherInterface;

class Md5Hasher implements HasherInterface {

    public function hash($string) {
        return md5($string);
    }

}
