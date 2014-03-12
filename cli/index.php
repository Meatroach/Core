<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

$console = new Application;
$console->register('install')
        ->setDescription('install the database')
        ->setCode(function (InputInterface $input, OutputInterface $output) {
            var_dump($input);
        });

$console->run();
