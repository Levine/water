<?php
/**
 * User: Ivan C. Sanches
 * Date: 24/09/13
 * Time: 16:23
 */
namespace Water\Library\Kernel\EventListener;

use Water\Library\EventDispatcher\EventDispatcherInterface;
use Water\Library\EventDispatcher\SubscriberInterface;
use Water\Library\Http\Response;
use Water\Library\Kernel\Event\ResponseFromExceptionEvent;
use Water\Library\Kernel\KernelEvents;

/**
 * Class ExceptionListener
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ExceptionListener implements SubscriberInterface
{
    /**
     * @var mixed
     */
    protected $controller;

    /**
     * Constructor.
     *
     * @param mixed $controller
     */
    public function __construct($controller)
    {
        $this->controller = $controller;
    }

    /**
     * Subscribed method.
     *
     * @param ResponseFromExceptionEvent $event
     * @param string                     $eventName
     * @param EventDispatcherInterface   $dispatcher
     */
    public function onKernelException(ResponseFromExceptionEvent $event, $eventName, EventDispatcherInterface $dispatcher)
    {
        $request          = $event->getRequest();
        $exceptionRequest = $request->duplicate(
            array(),
            array(
                '_controller'   => $this->controller,
                '_args'         => $event->getException(),
            )
        );

        try {
            $response = $event->getKernel()->handle($exceptionRequest, false);
        } catch (\Exception $exception) {
            return;
        }

        $event->setResponse($response);
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::EXCEPTION => array('onKernelException', 64)
        );
    }
}