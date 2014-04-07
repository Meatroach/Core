<?php

namespace OpenTribes\Core\Silex;

use OpenTribes\Core\Silex\Repository\DBALCity as CityRepository;
use OpenTribes\Core\Silex\Repository\DBALMap as MapRepository;
use OpenTribes\Core\Silex\Repository\DBALMapTiles as MapTilesRepository;
use OpenTribes\Core\Silex\Repository\DBALUser as UserRepository;
use Silex\Application;

/**
 * Description of Repository
 *
 * @author BlackScorp<witalimik@web.de>
 */
abstract class Repository {

    const USER      = 'repository.core.user';
    const CITY      = 'repository.core.city';
    const MAP       = 'repository.core.map';
    const MAP_TILES = 'repository.core.mapTiles';

    public static function create(Application &$app) {
        $app[Repository::USER] = $app->share(function() use($app) {
            return new UserRepository($app['db']);
        });
        $app[Repository::CITY] = $app->share(function() use($app) {
            return new CityRepository($app['db']);
        });
        $app[Repository::MAP] = $app->share(function() use($app) {
            return new MapRepository($app['db']);
        });
        $app[Repository::MAP_TILES] = $app->share(function() use($app) {
            return new MapTilesRepository($app['db']);
        });
    }

}
