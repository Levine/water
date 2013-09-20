<?php
/**
 * User: Ivan C. Sanches
 * Date: 20/09/13
 * Time: 10:36
 */
namespace Water\Library\EventDispatcher\Tests\Resource;

use Water\Library\EventDispatcher\Event;

/**
 * Class Listener
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class Listener
{
    public function someMethod(Event $event)
    {
    }

    public function increment(IncrementEvent $event)
    {
        $event->stopPropagation();
        $event->value++;
    }
}