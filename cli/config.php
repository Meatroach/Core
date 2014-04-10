#!/usr/bin/env php
<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use OpenTribes\Core\Silex\Repository;

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

$console->register('create-dummy-map')
        ->addArgument('env', InputArgument::OPTIONAL, 'enviroment', 'test')
        ->setCode(function(InputInterface $input) {
            $env               = $input->getArgument('env');
            $app               = require __DIR__ . '/../bootstrap.php';
            $mapOptions        = $app['map.options'];
            $mapRepository     = $app[Repository::MAP];
            $tileRepository    = $app[Repository::TILE];
            $mapTileRepository = $app[Repository::MAP_TILES];

            $mapId = $mapRepository->getUniqueId();
            $map   = $mapRepository->create($mapId, 'Dummy');
            $map->setWidth($mapOptions['width']);
            $map->setHeight($mapOptions['height']);
            $mapRepository->add($map);


            $tileId  = $tileRepository->getUniqueId();
            $tile    = $tileRepository->create($tileId, 'gras', true);
            $tile->setWidth($mapOptions['tileWidth']);
            $tile->setHeight($mapOptions['tileHeight']);
            $tile->setDefault(true);
            $tileRepository->add($tile);
            $tiles   = array('forrest', 'hill', 'sea');
            $tileIds = array();
            foreach ($tiles as $tileName) {
                $tileId           = $tileRepository->getUniqueId();
                $tile             = $tileRepository->create($tileId, $tileName, false);
                $tile->setWidth($mapOptions['tileWidth']);
                $tile->setHeight($mapOptions['tileHeight']);
                $tileRepository->add($tile);
                $tileIds[$tileId] = $tileId;
            }

            for ($y = 0; $y <= $mapOptions['height']; $y++) {
                for ($x = 0; $x <= $mapOptions['width']; $x++) {
                    $rand = rand(0, 100);
                    if ($rand > 80) {
                        $randomTileId = $tileIds[array_rand($tileIds)];
                        $tile         = $tileRepository->findById($randomTileId);
                        $map->addTile($tile, $y, $x);
                    }
                }
            }
            $mapTileRepository->add($map);


            $mapRepository->sync();
            $tileRepository->sync();
            $mapTileRepository->sync();
        });
$console->run();
