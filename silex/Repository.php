<?php

namespace OpenTribes\Core\Silex;

use OpenTribes\Core\Silex\Repository\DBALCity as CityRepository;
use OpenTribes\Core\Silex\Repository\DBALMap as MapRepository;
use OpenTribes\Core\Silex\Repository\DBALMapTiles as MapTilesRepository;
use OpenTribes\Core\Silex\Repository\DBALTile as TileRepository;
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
    const TILE = 'repository.core.tile';
    public static function create(Application &$app) {
        $app[self::USER] = $app->share(function() use($app) {
            return new UserRepository($app['db']);
        });
        $app[self::CITY] = $app->share(function() use($app) {
            return new CityRepository($app['db']);
        });
        $app[self::MAP] = $app->share(function() use($app) {
            return new MapRepository($app['db']);
        });
        $app[self::MAP_TILES] = $app->share(function() use($app) {
            return new MapTilesRepository($app['db']);
        });
        $app[self::TILE] = $app->share(function() use($app){
            return new TileRepository($app['db']);
        });
    }

}
