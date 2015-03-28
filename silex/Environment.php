<?php
namespace OpenTribes\Core\Silex;

class Environment
{
    const TEST = 'test';
    const DEVELOP = 'develop';
    const PRODUCTION = 'production';
    private $env = 'test';

    public function set($environment){
        $this->env = $environment;
    }
    public function setIp($ip){
        $this->env = (!filter_var(
            $ip,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
        ) ? self::DEVELOP : self::PRODUCTION);
    }
    public function get()
    {
        return $this->env;
    }

}
