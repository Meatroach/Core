<?php

namespace OpenTribes\Core\Service;

/**
 *
 * @author BlackScorp<witalimik@web.de>
 */
interface ActivationCodeGenerator {

    /**
     * @return string
     */
    public function create();
}
