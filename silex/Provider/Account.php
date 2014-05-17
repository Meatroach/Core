<?php
namespace OpenTribes\Core\Silex\Provider;

use Silex\ControllerProviderInterface;
use Silex\Application;
use OpenTribes\Core\Silex\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use OpenTribes\Core\Silex\RouteValue;
use Swift_Message;

class Account implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $account = $app['controllers_factory'];
        $account->get('/logout', function()use($app) {
            $baseUrl = $app['mustache.options']['helpers']['baseUrl'];
            $app['session']->remove('username');

            return new RedirectResponse($baseUrl);
        });
        $account->post('/login', Controller::ACCOUNT . ':loginAction')
                ->value(RouteValue::TEMPLATE, 'pages/landing')
                ->value(RouteValue::SUCCESS_HANDLER, function($appResponse) use ($app) {
                    $baseUrl = $app['mustache.options']['helpers']['baseUrl'];
                    $app['session']->set('username', $appResponse->username);

                    return new RedirectResponse($baseUrl);
                })
                ->value(RouteValue::SUB_REQUESTS, array(
                    array(
                        'url'    => '/',
                        'method' => 'GET',
                        'param'  => array())
        ));
        $account->get('/registration_successfull', function() use($app) {
            $baseUrl = $app['mustache.options']['helpers']['baseUrl'];
          $response = new Response();

            $class= new \stdClass();
            $class->proceed = true;
            $class->failed = false;
            return $class;
        })->value(RouteValue::TEMPLATE, 'pages/registration_successfull');

        $account->match('/create', Controller::ACCOUNT . ':createAction')
                ->method('GET|POST')
                ->value(RouteValue::SUCCESS_HANDLER, function($appResponse) use ($app) {
                    $baseUrl = $app['mustache.options']['helpers']['baseUrl'];
                    $request = $app['request'];

                    $appResponse->url = $request->getHttpHost();

                    $htmlBody = $app['mustache']->render('mails/html/register', $appResponse);
                    $textBody = $app['mustache']->render('mails/text/register', $appResponse);
                    $message  = Swift_Message::newInstance($app['subjects']['registration'])
                            ->setFrom($app['fromMails']['registration'])
                            ->setTo($appResponse->email)
                            ->setBody($htmlBody, 'text/html')
                            ->addPart($textBody, 'text/plain');

                    if ($app['mailer']->send($message)) {
                        $target = $baseUrl . 'account/registration_successfull';
                    } else {
                        $target = $baseUrl . 'account/registration_failed';
                    }
                    return new RedirectResponse($target);
                })
                ->value(RouteValue::TEMPLATE, 'pages/registration');


        $account->match('/activate', Controller::ACCOUNT . ':activateAction')
                ->method('GET|POST')
                ->value(RouteValue::TEMPLATE, 'pages/activation');

        $account->get('/activate/{username}/{activationKey}', Controller::ACCOUNT . ':activateAction')
                ->value(RouteValue::TEMPLATE, 'pages/activation');

        $account->after(function() use($app) {

            return $app[Controller::ACCOUNT]->after();
        });

        return $account;
    }
}
