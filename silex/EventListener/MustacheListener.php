<?php

namespace OpenTribes\Core\Silex\EventListener;


use OpenTribes\Core\Silex\Response\MustacheResponse;
use OpenTribes\Core\Silex\Response\SFBaseResponse;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class MustacheListener implements EventSubscriberInterface{
    private $mustache;
    public function __construct(\Mustache_Engine $mustache){
        $this->mustache = $mustache;
    }
    public function onView(GetResponseForControllerResultEvent $event){
        /**
         * @var SFBaseResponse | Response $controllerResult;
         */
        $controllerResult = $event->getControllerResult();
        $request = $event->getRequest();
        if ($controllerResult instanceof Response) {
            $event->setResponse($controllerResult);
            return;
        }

        if($controllerResult instanceof SFBaseResponse){
            $response = new MustacheResponse();
            $templateName = $request->get('template');
            $htmlContent = $this->mustache->render($templateName,$controllerResult);
            $controllerResult->setRequest($request);
            $response->setContent($htmlContent);
            $response->setResponse($controllerResult);
            $event->setResponse($response);
        }

    }
    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     *
     * @api
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::VIEW => 'onView'
        );
    }

} 