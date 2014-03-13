<?php

require_once __DIR__ . '/../bootstrap.php';

use OpenTribes\Core\Silex\Shema;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

$console = new Application;
$console->register('install-shema')
        ->setDescription('install the database')
        ->setCode(function (InputInterface $input, OutputInterface $output) use($app) {
            $shema = new Shema($app['db']);
            $shema->installShema();
        });

$console->register('install-roles')
        ->setDescription('install the database')
        ->setCode(function (InputInterface $input, OutputInterface $output) use($app) {
            $shema = new Shema($app['db']);
            $shema->createRoles();
        });

$console->run();
