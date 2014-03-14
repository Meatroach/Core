<?php

require_once __DIR__ . '/../bootstrap.php';

use OpenTribes\Core\Silex\Shema;
use Symfony\Component\Console\Application;

$console = new Application;
$console->register('install-shema')
        ->setDescription('install the database')
        ->setCode(function () use($app) {
            $shema = new Shema($app['db']);
            $shema->installShema();
        });

$console->register('install-roles')
        ->setDescription('install the database')
        ->setCode(function () use($app) {
            $shema = new Shema($app['db']);
            $shema->createRoles();
        });

$console->run();
