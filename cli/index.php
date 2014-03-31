#!/usr/bin/env php
<?php
require_once __DIR__ . '/../vendor/autoload.php';

use OpenTribes\Core\Silex\Schema;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;

$console = new Application;

$console->register('install-schema')
        ->setDescription('install the database')
        ->addArgument('env', InputArgument::OPTIONAL, 'Sets the enviroment for schema ', 'test')
        ->setCode(function (InputInterface $input) {

            $env   = $input->getArgument('env');
            $app   = require __DIR__ . '/../bootstrap.php';
            $shema = new Schema($app['db']);
            $shema->installSchema();
        });

$console->register('install-roles')
        ->setDescription('install roles')
        ->addArgument('env', InputArgument::OPTIONAL, 'Sets the enviroment for schema ', 'test')
        ->setCode(function (InputInterface $input) {
            $env   = $input->getArgument('env');
            $app   = require __DIR__ . '/../bootstrap.php';
            $shema = new Schema($app['db']);
            $shema->createRoles();
        });
$console->register('create-configuration')
        ->addArgument('env', InputArgument::OPTIONAL, 'Sets the enviroment for configuration ', 'test')
        ->setCode(function(InputInterface $input) {
            $env     = $input->getArgument('env');
            $path    = realpath(__DIR__ . '/../config/');
            $baseDir = $path . DIRECTORY_SEPARATOR . $env . DIRECTORY_SEPARATOR;
            if (!is_dir($baseDir)) {
                mkdir($baseDir);
            }
            foreach (glob($path . '/*.template.php') as $file) {
                $templateFile = realpath($file);
                $realFile     = $baseDir . basename(str_replace('.template', '', $templateFile));
                $content      = require $templateFile;
                if (file_exists($realFile)) {
                    $realFileContent = require $realFile;
                    $content         = array_replace_recursive($content, $realFileContent);
                }
                $newContent = "<?php \n return " . var_export($content, true) . ";";
                file_put_contents($realFile, $newContent);
            }
        });

$console->register('create-map')
        ->addArgument('env', InputArgument::OPTIONAL, 'Sets the enviroment for configuration ', 'test')
        ->setCode(function(InputInterface $input) {
                $env   = $input->getArgument('env');
            $app   = require __DIR__ . '/../bootstrap.php';
            $mapRepository = $app[\OpenTribes\Core\Silex\Repository::MAP];
        });

$console->run();
