<?php
/**
 * User: Ivan C. Sanches
 * Date: 28/10/13
 * Time: 19:26
 */
namespace Water\Module\TeapotModule\EventListener;

use Water\Library\EventDispatcher\EventDispatcherInterface;
use Water\Library\EventDispatcher\SubscriberInterface;
use Water\Library\Kernel\Event\ResponseFromControllerResultEvent;
use Water\Library\Kernel\KernelEvents;

/**
 * Class TemplateListener
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class TemplateListener implements SubscriberInterface
{
    /**
     * @param ResponseFromControllerResultEvent $event
     * @param string                            $eventName
     * @param EventDispatcherInterface          $dispatcher
     */
    public function onKernelView(ResponseFromControllerResultEvent $event, $eventName, EventDispatcherInterface $dispatcher)
    {

    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::VIEW => array('onKernelView', 64)
        );
    }
}