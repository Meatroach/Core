<?php
namespace OpenTribes\Core\Silex\Provider;

use OpenTribes\Core\Silex\Controller;
use OpenTribes\Core\Silex\RouteValue;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Swift_Message;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Silex\ControllerCollection;

class Account implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        /**
         * @var ControllerCollection $account
         */
        $account = $app['controllers_factory'];

        $account->get(
            '/logout',
            function () use ($app) {
                $baseUrl = $app['mustache.options']['helpers']['baseUrl'];
                /**
                 * @var $app ['session'] Session
                 */
                $app['session']->remove('username');

                return new RedirectResponse($baseUrl);
            }
        );
        $account->post('/login', Controller::ACCOUNT . ':loginAction')
            ->value(RouteValue::TEMPLATE, 'pages/landing')
            ->value(
                RouteValue::SUCCESS_HANDLER,
                function ($appResponse) use ($app) {
                    $baseUrl = $app['mustache.options']['helpers']['baseUrl'];
                    $app['session']->set('username', $appResponse->username);

                    return new RedirectResponse($baseUrl);
                }
            )
            ->value(
                RouteValue::SUB_REQUESTS,
                array(
                    array(
                        'url'    => '/',
                        'method' => 'GET',
                        'param'  => array()
                    )
                )
            );
        $account->get(
            '/registration_successfull',
            function () use ($app) {
         
                $class          = new \stdClass();
                $class->proceed = true;
                $class->failed  = false;
                return $class;
            }
        )->value(RouteValue::TEMPLATE, 'pages/registration_successfull');

        $account->match('/create', Controller::ACCOUNT . ':createAction')
            ->method('GET|POST')
            ->value(
                RouteValue::SUCCESS_HANDLER,
                function ($appResponse) use ($app) {
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
                }
            )
            ->value(RouteValue::TEMPLATE, 'pages/registration');


        $account->match('/activate', Controller::ACCOUNT . ':activateAction')
            ->method('GET|POST')
            ->value(RouteValue::TEMPLATE, 'pages/activation');

        $account->get('/activate/{username}/{activationKey}', Controller::ACCOUNT . ':activateAction')
            ->value(RouteValue::TEMPLATE, 'pages/activation');

        $account->get(
            '/login',
            function () use ($app) {

                return $app->redirect($app['mustache.options']['helpers']['baseUrl']);
            }
        );

        $account->after(
            function () use ($app) {

                return $app[Controller::ACCOUNT]->after();
            }
        );

        return $account;
    }
}
