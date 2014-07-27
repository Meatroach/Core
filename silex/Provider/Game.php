<?php
namespace OpenTribes\Core\Silex\Provider;

use OpenTribes\Core\Silex\Controller;
use OpenTribes\Core\Silex\Repository;
use OpenTribes\Core\Silex\RouteValue;
use Silex\Application;
use Silex\ControllerProviderInterface;
use stdClass;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class Game implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $game = $app['controllers_factory'];
        $game->before(
            function (Request $request) use ($app) {

                $cityController = $app[Controller::CITY];
                $response = $cityController->listAction($request);
                $baseUrl = $app['mustache.options']['helpers']['baseUrl'];
                $startUrl = $baseUrl . 'game/start';
                if ($response->failed && $request->getRequestUri() !== $startUrl) {
                    if (!$app['session']->has('username')) {
                        return new RedirectResponse($app['mustache.options']['helpers']['baseUrl']);
                    }
                    return new RedirectResponse($startUrl);
                }
                return null;
            }
        );
        $game->get('/map/{posY}/{posX}', Controller::MAP . ':viewAction')
            ->value('posY', null)
            ->value('posX', null)
            ->value('width', $app['map.options']['viewportWidth'])
            ->value('height', $app['map.options']['viewportHeight'])
            ->value(RouteValue::TEMPLATE, 'pages/game/map');

        $game->get(
            '/',
            function (Request $request) {
                $response = new stdClass();
                $response->proceed = false;
                $response->username = $request->getSession()->get('username');
                return $response;
            }
        )->value(RouteValue::TEMPLATE, 'pages/game/landing');
        $game->get('game/city/{posY}/{posX}', Controller::CITY . ':locationAction');
        $game->get('/city/list/{username}', Controller::CITY . ':listAction')
            ->value('username', null)
            ->value(RouteValue::TEMPLATE, 'pages/game/citylist');

        $game->match('/start', Controller::CITY . ':newAction')
            ->value(
                RouteValue::SUCCESS_HANDLER,
                function () use ($app) {

                    $baseUrl = $app['mustache.options']['helpers']['baseUrl'];
                    return new RedirectResponse($baseUrl . 'game/city/list');
                }
            )
            ->before(
                function (Request $request) use ($app) {
                    $cityController = $app[Controller::CITY];
                    $response = $cityController->listAction($request);
                    $baseUrl = $app['mustache.options']['helpers']['baseUrl'];
                    $cityListUrl = $baseUrl . 'game/city/list';

                    if (!$response->failed) {
                        return new RedirectResponse($cityListUrl);
                    }
                    return null;
                }
            )
            ->method('POST|GET')
            ->value(RouteValue::TEMPLATE, 'pages/game/newcity');

        $game->after(
            function () use ($app) {
                $app[Repository::CITY]->sync();
            }
        );
        return $game;
    }
}
