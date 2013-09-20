<?php
/**
 * User: Ivan C. Sanches
 * Date: 20/09/13
 * Time: 14:31
 */
namespace Water\Library\EventDispatcher\Tests\Resource;

use Water\Library\EventDispatcher\Event;

/**
 * Class IncrementEvent
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class IncrementEvent extends Event
{
    public $value = 0;
}