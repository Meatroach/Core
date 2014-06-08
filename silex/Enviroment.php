<?php

namespace OpenTribes\Core\Silex;

/**
 * Description of Enviroment
 *
 * @author Witali
 */
abstract class Enviroment
{

    const TEST = 'test';
    const DEV  = 'develop';
    const PROD = 'production';

    public static function all()
    {
        return array(
            self::TEST,
            self::DEV,
            self::PROD
        );
    }

}
