<?php
/**
 * User: Ivan C. Sanches
 * Date: 20/09/13
 * Time: 15:44
 */
namespace Water\Library\EventDispatcher\Tests\Resource;

use Water\Library\EventDispatcher\EventDispatcherInterface;
use Water\Library\EventDispatcher\SubscriberInterface;

/**
 * Class Subscriber
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class Subscriber implements SubscriberInterface
{
    public function increment(IncrementEvent $event, $eventName, EventDispatcherInterface $dispatcher)
    {
        $event->value++;
    }

    public function decrement(IncrementEvent $event, $eventName, EventDispatcherInterface $dispatcher)
    {
        $event->value--;
    }

    public static function getSubscribedEvents()
    {
        return array(
            'test_string'       => 'increment',
            'test_array'        => array('increment', 0),
            'test_array_array'  => array(array('decrement', 2), array('increment')),
        );
    }
}