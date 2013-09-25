<?php
/**
 * User: Ivan C. Sanches
 * Date: 25/09/13
 * Time: 09:51
 */
namespace Water\Library\Kernel\EventListener;

use Water\Library\EventDispatcher\EventDispatcherInterface;
use Water\Library\EventDispatcher\SubscriberInterface;
use Water\Library\Kernel\Event\FilterResponseEvent;
use Water\Library\Kernel\KernelEvents;

/**
 * Class ResponseListener
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ResponseListener implements SubscriberInterface
{
    private $charset = 'UTF-8';

    /**
     * Constructor.
     *
     * @param string $charset
     */
    public function __construct($charset = 'UTF-8')
    {
        $this->charset = $charset;
    }

    /**
     * Subscribed method.
     *
     * @param FilterResponseEvent      $event
     * @param string                   $eventName
     * @param EventDispatcherInterface $dispatcher
     */
    public function onKernelResponse(FilterResponseEvent $event, $eventName, EventDispatcherInterface $dispatcher)
    {
        $response = $event->getResponse();

        $charset = $response->getCharset();
        if (!empty($charset)) {
            return;
        }

        $charset = strtolower($this->charset);
        $headers = $response->getHeaders();
        if (!$headers->has('Content-Type')) {
            $headers->set('Content-Type', 'text/html; charset='.$charset);
        } elseif (
            0 === strpos($headers->get('Content-Type'), 'text/')
            && false === strpos($headers->get('Content-Type'), 'charset')
        ) {
            $headers->set('Content-Type', $headers->get('Content-Type').'; charset='.$charset);
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::RESPONSE => array('onKernelResponse', 64)
        );
    }
}