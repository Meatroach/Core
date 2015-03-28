<?php
namespace OpenTribes\Core\Silex;

class Environment
{
    const TEST = 'test';
    const DEVELOP = 'develop';
    const PRODUCTION = 'production';
    private $env = null;

    public function __construct($ip,$environment = '')
    {

        $this->env = (!filter_var(
            $ip,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
        ) ? self::DEVELOP : self::PRODUCTION);

        if($environment === self::TEST){
            $this->env = self::TEST;
        }
    }

    public function get()
    {
        return $this->env;
    }

}
