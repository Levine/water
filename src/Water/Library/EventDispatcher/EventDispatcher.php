<?php
/**
 * User: Ivan C. Sanches
 * Date: 20/09/13
 * Time: 09:40
 */
namespace Water\Library\EventDispatcher;

/**
 * Class EventDispatcher
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class EventDispatcher implements EventDispatcherInterface
{
    /**
     * @var array
     */
    private $listeners = array();

    /**
     * @var array
     */
    private $sorted = array();

    /**
     * {@inheritdoc}
     */
    public function addListener($eventName, $callback, $priority = 0)
    {
        $this->listeners[$eventName][$priority][] = $callback;
        unset($this->sorted[$eventName]);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeListener($eventName, $callback)
    {
        if (isset($this->listeners[$eventName])) {
            foreach ($this->listeners[$eventName] as $priority => $listeners) {
                $key = array_search($callback, $listeners, true);
                if ($key !== false) {
                    unset($this->listeners[$eventName][$priority][$key]);
                    unset($this->sorted[$eventName]);
                }
            }
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addSubscriber(SubscriberInterface $subscriber)
    {
        foreach ($subscriber->getSubscribedEvents() as $eventName => $value) {
            if (is_string($value)) {
                $this->addListener($eventName, array($subscriber, $value));
            } elseif (is_string($value[0])) {
                $this->addListener($eventName, array($subscriber, $value[0]), isset($value[1]) ? $value[1] : 0);
            } else {
                foreach ($value as $listener) {
                    $this->addListener($eventName, array($subscriber, $listener[0]), (isset($listener[1])) ? $listener[1] : 0);
                }
            }
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeSubscriber(SubscriberInterface $subscriber)
    {
        foreach ($subscriber->getSubscribedEvents() as $eventName => $value) {
            if (is_string($value)) {
                $this->removeListener($eventName, array($subscriber, $value));
            } elseif (is_string($value[0])) {
                $this->removeListener($eventName, array($subscriber, $value[0]));
            } else {
                foreach ($value as $listener) {
                    $this->removeListener($eventName, array($subscriber, $listener[0]));
                }
            }
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch($eventName, Event $event = null)
    {
        if ($event === null) {
            $event = new Event();
        }

        if (!isset($this->sorted[$eventName])) {
            $this->sortListeners($eventName);
        }

        foreach ($this->getListeners($eventName) as $listener) {
            call_user_func($listener, $event);

            if ($event->isStoppedPropagation()) {
                break;
            }
        }

        return $event;
    }

    /**
     * {@inheritdoc}
     */
    public function getListeners($eventName = '')
    {
        if ($eventName === '') {
            foreach ($this->listeners as $key => $value) {
                $this->sortListeners($key);
            }

            return $this->sorted;
        }

        if (!isset($this->sorted[$eventName])) {
            $this->sortListeners($eventName);
        }

        return (isset($this->sorted[$eventName])) ? $this->sorted[$eventName] : array();
    }

    /**
     * Sort the listeners by priority.
     *
     * @param string $eventName
     * @return EventDispatcher
     */
    private function sortListeners($eventName)
    {
        if (isset($this->listeners[$eventName])) {
            ksort($this->listeners[$eventName]);
            $this->sorted[$eventName] = call_user_func_array('array_merge', $this->listeners[$eventName]);
        }
        return $this;
    }
}