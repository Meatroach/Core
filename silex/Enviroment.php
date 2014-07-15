<?php

namespace OpenTribes\Core\Silex;

class Enviroment {
    const TEST = 'test';
    const DEVELOP = 'develop';
    const PRODUCTION = 'production';
    private static $env = null;
    private static function loadFromGlobals(){
        if(isset( $_SERVER['REMOTE_ADDR'])){
            self::$env = (!filter_var(
                $_SERVER['REMOTE_ADDR'],
                FILTER_VALIDATE_IP,
                FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
            ) ? Enviroment::DEVELOP : Enviroment::PRODUCTION);
        }


        if(isset( $_ENV['env']) && $_ENV['env'] === Enviroment::TEST){
            self::$env = Enviroment::TEST;
        }
    }
    public function get(){
        if(!self::$env){
            self::loadFromGlobals();
        }
        return self::$env;
    }
    public static function isTest(){
        if(!self::$env){
            self::loadFromGlobals();
        }
        return self::$env === Enviroment::TEST;
    }
    public static function isDevelop(){
        if(!self::$env){
            self::loadFromGlobals();
        }
        return self::$env === Enviroment::DEVELOP;
    }
    public static function isProduction(){
        if(!self::$env){
            self::loadFromGlobals();
        }
        return self::$env === Enviroment::PRODUCTION;
    }

}
