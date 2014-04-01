#!/usr/bin/env php
<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Doctrine\DBAL\Migrations\Tools\Console\Command\DiffCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\ExecuteCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\GenerateCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\MigrateCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\StatusCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\VersionCommand;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use OpenTribes\Core\Silex\Enviroment as Env;
use OpenTribes\Core\Silex\Schema;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Helper\DialogHelper;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;

$env = 'test';

$argument = end($argv);
if (in_array($argument, Env::all())) {
    $env = $argument;
}
$app = require __DIR__ . '/../bootstrap.php';

$console   = new Application;
$helperSet = new HelperSet(array(
    new ConnectionHelper($app['db']),
    new DialogHelper(),
        ));

$console->setHelperSet($helperSet);

$console->addCommands(array(
    new DiffCommand(),
    new ExecuteCommand(),
    new GenerateCommand(),
    new MigrateCommand(),
    new StatusCommand(),
    new VersionCommand()
));




$console->register('install-schema')
        ->setDescription('install the database')
        ->setCode(function (InputInterface $input) use($app) {
            $shema = new Schema($app['db']);
            $shema->installSchema();
        });

$console->register('install-roles')
        ->setDescription('install roles')
        ->setCode(function (InputInterface $input)use($app) {
            $shema = new Schema($app['db']);
            $shema->createRoles();
        });
$console->register('create-configuration')
        ->setCode(function(InputInterface $input) use($env) {

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


$console->run();
