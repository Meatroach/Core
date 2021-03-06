<?php

namespace OpenTribes\Core\Silex\EventListener;


use Silex\Application;
use Silex\CallbackResolver;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class BeforeAfterListener implements EventSubscriberInterface
{
    /**
     * @var Application
     */
    private $app;
    /**
     * @var CallbackResolver
     */
    private $resolver;

    public function __construct(Application $app, CallbackResolver $resolver)
    {
        $this->resolver = $resolver;
        $this->app = $app;
    }

    public function onBeforeWithAction(GetResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }

        $callBack = $this->getCallback($event, 'before');
        if (!$callBack) {
            return;
        }
        $this->handleBeforeCallBack($event, $callBack);

    }

    public function onBefore(GetResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }

        $callBack = $this->getCallback($event, 'before', false);
        if (!$callBack) {
            return;
        }
        $this->handleBeforeCallBack($event, $callBack);

    }

    public function onAfterWithAction(FilterResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }
        $callBack = $this->getCallback($event, 'after');
        if (!$callBack) {
            return;
        }
        $this->handleAfterCallBack($event, $callBack);

    }

    public function onAfter(FilterResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }
        $callBack = $this->getCallback($event, 'after', false);
        if (!$callBack) {
            return;
        }
        $this->handleAfterCallBack($event, $callBack);

    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [
                ['onBefore', 2],
                ['onBeforeWithAction', 1]
            ],
            KernelEvents::RESPONSE => [
                ['onAfter', 1],
                ['onAfterWithAction', 2]
            ]
        ];
    }

    private function getCallback(KernelEvent $event, $prefix, $withAction = true)
    {

        $controller = $event->getRequest()->get('_controller');
        $callback = $this->resolver->resolveCallback($controller);
        if (!is_array($callback)) {
            return null;
        }
        $object = $callback[0];
        $methodName = $prefix;
        if ($withAction) {
            $methodName .= ucfirst($callback[1]);
        }
        $newCallBack = [
            $object,
            $methodName
        ];
        if (!method_exists($object, $methodName)) {
            return null;
        }
        return $newCallBack;

    }

    /**
     * @param GetResponseEvent $event
     * @param $callBack
     */
    private function handleBeforeCallBack(GetResponseEvent $event, $callBack)
    {
        $parameters = [
            $event->getRequest(),
            $this->app
        ];
        $response = call_user_func_array($callBack, $parameters);

        if ($response instanceof Response) {
            $event->setResponse($response);
        }
    }

    /**
     * @param FilterResponseEvent $event
     * @param $callBack
     */
    private function handleAfterCallBack(FilterResponseEvent $event, $callBack)
    {
        $parameters = [
            $event->getRequest(),
            $event->getResponse(),
            $this->app
        ];
        $response = call_user_func_array($callBack, $parameters);

        if ($response instanceof Response) {
            $event->setResponse($response);
        }
    }

}