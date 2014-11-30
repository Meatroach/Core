<?php
namespace OpenTribes\Core\Silex;

class Environment
{
    const TEST = 'test';
    const DEVELOP = 'develop';
    const PRODUCTION = 'production';
    private static $env = null;

    private static function loadFromGlobals()
    {
        if (isset($_SERVER['REMOTE_ADDR'])) {
            self::$env = (!filter_var(
                $_SERVER['REMOTE_ADDR'],
                FILTER_VALIDATE_IP,
                FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
            ) ? self::DEVELOP : self::PRODUCTION);
        }


        if (isset($_ENV['env']) && $_ENV['env'] === self::TEST) {
            self::$env = self::TEST;
        }
    }

    public function get()
    {
        if (!self::$env) {
            self::loadFromGlobals();
        }
        return self::$env;
    }

}
