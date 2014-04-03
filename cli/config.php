#!/usr/bin/env php
<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;

$console = new Application;
$console->register('create')
        ->addArgument('env', InputArgument::OPTIONAL, 'enviroment', 'test')
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


$console->run();
