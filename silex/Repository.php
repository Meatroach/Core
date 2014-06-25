<?php

namespace OpenTribes\Core\Silex;

use OpenTribes\Core\Mock\Repository\Building;
use OpenTribes\Core\Mock\Repository\CityBuildings;
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
class Repository
{

    const USER = 'repository.core.user';
    const CITY = 'repository.core.city';
    const MAP = 'repository.core.map';
    const MAP_TILES = 'repository.core.mapTiles';
    const TILE = 'repository.core.tile';
    const BUILDING = 'repository.core.building';
    const CITY_BUILDINGS = 'repository.core.cityBuildings';
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function create()
    {
        $app = $this->app;
        $app[self::USER] = $app->share(
            function () use ($app) {
                return new UserRepository($app['connection']);
            }
        );
        $app[self::CITY] = $app->share(
            function () use ($app) {
                return new CityRepository($app['connection']);
            }
        );
        $app[self::MAP] = $app->share(
            function () use ($app) {
                return new MapRepository($app['connection']);
            }
        );
        $app[self::MAP_TILES] = $app->share(
            function () use ($app) {
                return new MapTilesRepository($app['connection']);
            }
        );
        $app[self::TILE] = $app->share(
            function () use ($app) {
                return new TileRepository($app['connection']);
            }
        );
        $app[self::BUILDING] = $app->share(
            function () {
                return new Building();
            }
        );
        $app[self::CITY_BUILDINGS] = $app->share(
            function () use ($app) {
                return new CityBuildings($app[Repository::CITY]);
            }
        );
    }
}
