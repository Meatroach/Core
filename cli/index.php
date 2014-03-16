<?php

require_once __DIR__ . '/../vendor/autoload.php';

use OpenTribes\Core\Silex\Shema;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;

$console = new Application;

$console->register('install-shema')
        ->setDescription('install the database')
        ->addArgument('env', InputArgument::OPTIONAL, 'Sets the enviroment for shema ', 'test')
        ->setCode(function (InputInterface $input) {

            $env   = $input->getArgument('env');
            $app   = require __DIR__ . '/../bootstrap.php';
            $shema = new Shema($app['db']);
            $shema->installShema();
        });

$console->register('install-roles')
        ->setDescription('install roles')
        ->addArgument('env', InputArgument::OPTIONAL, 'Sets the enviroment for shema ', 'test')
        ->setCode(function (InputInterface $input) {
            $env   = $input->getArgument('env');
            $app   = require __DIR__ . '/../bootstrap.php';
            $shema = new Shema($app['db']);
            $shema->createRoles();
        });

$console->run();
