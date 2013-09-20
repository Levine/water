<?php
/**
 * User: Ivan C. Sanches
 * Date: 20/09/13
 * Time: 09:38
 */
namespace Water\Library\EventDispatcher;

/**
 * Class Event
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class Event
{
    /**
     * @var bool
     */
    private $stopPropagation = false;

    /**
     * Stop the propagation of the event.
     */
    public function stopPropagation()
    {
        $this->stopPropagation = true;
    }

    /**
     * Returns whether further event listeners should be triggered.
     *
     * @return bool
     */
    public function isStoppedPropagation()
    {
        return $this->stopPropagation;
    }
}