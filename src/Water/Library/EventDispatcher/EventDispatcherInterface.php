<?php
/**
 * User: Ivan C. Sanches
 * Date: 20/09/13
 * Time: 09:44
 */
namespace Water\Library\EventDispatcher;

/**
 * Interface EventDispatcherInterface
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
interface EventDispatcherInterface
{
    /**
     * Add a listener.
     *
     * @param string         $eventName
     * @param \Closure|array $callback
     * @param int            $priority
     * @return EventDispatcherInterface
     */
    public function addListener($eventName, $callback, $priority = 0);

    /**
     * Add a EventSubscriber.
     *
     * @param SubscriberInterface $subscriber
     * @return array
     */
    public function addSubscriber(SubscriberInterface $subscriber);

    /**
     * Remove a listener.
     *
     * @param string         $eventName
     * @param \Closure|array $callback
     * @return EventDispatcherInterface
     */
    public function removeListener($eventName, $callback);

    /**
     * Remove a EventSubscriber.
     *
     * @param SubscriberInterface $subscriber
     * @return EventDispatcherInterface
     */
    public function removeSubscriber(SubscriberInterface $subscriber);

    /**
     * Dispatches an event to registered listeners.
     *
     * @param string $eventName
     * @param Event  $event
     * @return Event
     */
    public function dispatch($eventName, Event $event);

    /**
     * Returns the listeners registered with the eventName.<br/>
     * If eventName = '', all the listeners are returned,
     * otherwise only the listeners registered with eventName are returned.
     *
     * @param string $eventName
     * @return array
     */
    public function getListeners($eventName = '');
}