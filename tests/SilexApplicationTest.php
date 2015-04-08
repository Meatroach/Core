<?php

namespace OpenTribes\Core\Test;


use Silex\Application;

abstract class SilexApplicationTest extends \PHPUnit_Framework_TestCase {
    private $app = null;
    /**
     * @return Application
     */
    public function getApplication(){
        if(!$this->app){
            $this->loadApplication();
        }
        return $this->app;

    }
    private function loadApplication(){
        $app = include __DIR__ . '/../bootstrap.php';
        $app->boot();
        $app['session.test'] = true;
        $this->app = $app;
    }
}
 