<?php
/**
 * User: Ivan C. Sanches
 * Date: 09/10/13
 * Time: 17:49
 */
namespace Water\Module\TemplateModule\EventListener;

use Water\Library\EventDispatcher\EventDispatcherInterface;
use Water\Library\EventDispatcher\SubscriberInterface;
use Water\Library\Kernel\Event\ResponseFromControllerEvent;
use Water\Library\Kernel\KernelEvents;

/**
 * Class TemplateListener
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class TemplateListener implements SubscriberInterface
{
    /**
     * @param ResponseFromControllerEvent $event
     * @param string                      $eventName
     * @param EventDispatcherInterface    $dispatcher
     */
    public function onKernelView(ResponseFromControllerEvent $event, $eventName, EventDispatcherInterface $dispatcher)
    {
        $response = $event->getResponse();
        if (!is_array($response)) {
            return;
        }


    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::VIEW => array('onKernelView', 64),
        );
    }
}