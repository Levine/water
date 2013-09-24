<?php
/**
 * User: Ivan C. Sanches
 * Date: 22/09/13
 * Time: 21:01
 */
namespace Water\Library\Kernel\EventListener;

use Water\Library\EventDispatcher\EventDispatcherInterface;
use Water\Library\EventDispatcher\SubscriberInterface;
use Water\Library\Kernel\Event\ResponseEvent;
use Water\Library\Kernel\Exception\RouteNotFoundException;
use Water\Library\Kernel\KernelEvents;
use Water\Library\Router\RouterInterface;

/**
 * Class RouterListener
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class RouterListener implements SubscriberInterface
{
    /**
     * @var RouterInterface
     */
    private $router = null;

    /**
     * Constructor.
     *
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * Subscribed method.
     *
     * @param ResponseEvent            $event
     * @param string                   $eventName
     * @param EventDispatcherInterface $dispatcher
     *
     * @throws RouteNotFoundException
     */
    public function onKernelRequest(ResponseEvent $event, $eventName, EventDispatcherInterface $dispatcher)
    {
        $request = $event->getRequest();

        if ($request->getResource()->has('_controller')) {
            return;
        }

        if ($resource = $this->router->match($request->getPath())) {
            $request->getResource()->fromArray($resource);
            return;
        }

        throw new RouteNotFoundException();
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => array('onKernelRequest', 64)
        );
    }
}