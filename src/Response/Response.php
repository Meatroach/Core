<?php

namespace OpenTribes\Core\Response;

/**
 * Description of Response
 *
 * @author BlackScorp<witalimik@web.de>
 */
abstract class Response
{
    public $errors = array();
    public $proceed = false;
    public $failed = true;
}
