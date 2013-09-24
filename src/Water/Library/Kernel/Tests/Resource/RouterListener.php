<?php
/**
 * User: Ivan C. Sanches
 * Date: 24/09/13
 * Time: 09:34
 */
namespace Water\Library\Kernel\Tests\Resource;

use Water\Library\EventDispatcher\SubscriberInterface;
use Water\Library\Kernel\Event\ResponseEvent;
use Water\Library\Kernel\KernelEvents;

/**
 * Class RouterListener
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class RouterListener implements SubscriberInterface
{
    public function onKernelRequest(ResponseEvent $event)
    {
        $request = $event->getRequest();

        if ($request->getResource()->has('_controller')) {
            $response = call_user_func_array($request->getResource()->get('_controller'), array());
            $event->setResponse($response);
            return;
        }
        return;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => array('onKernelRequest', 0)
        );
    }
}