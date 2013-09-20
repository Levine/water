<?php
/**
 * User: Ivan C. Sanches
 * Date: 20/09/13
 * Time: 10:35
 */
namespace Water\Library\EventDispatcher\Tests;

use Water\Library\EventDispatcher\Event;
use Water\Library\EventDispatcher\EventDispatcher;
use Water\Library\EventDispatcher\Tests\Resource\IncrementEvent;
use Water\Library\EventDispatcher\Tests\Resource\Listener;
use Water\Library\EventDispatcher\Tests\Resource\Subscriber;

/**
 * Class EventDispatcherTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class EventDispatcherTest extends \PHPUnit_Framework_TestCase 
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testDispatcherClosure()
    {
        $dispatcher = new EventDispatcher();
        $dispatcher->addListener('closure', function (Event $event) { $event; }, 0);
        $event = $dispatcher->dispatch('closure');

        $this->assertInstanceOf('\Water\Library\EventDispatcher\Event', $event);
    }

    public function testDispatcherMethod()
    {
        $dispatcher = new EventDispatcher();
        $dispatcher->addListener('method', array(new Listener(), 'someMethod'), 0);
        $event = $dispatcher->dispatch('method');

        $this->assertInstanceOf('\Water\Library\EventDispatcher\Event', $event);
    }

    public function testRemoveListener()
    {
        $priority = 0;

        $dispatcher = new EventDispatcher();
        $dispatcher->addListener('test_remove', $method = array(new Listener(), 'someMethod'), $priority);
        $dispatcher->addListener('test_remove', $closure = function (Event $event) { $event; }, $priority);

        $listeners = $dispatcher->getListeners('test_remove');

        $this->assertCount(2, $listeners);

        $dispatcher->removeListener('test_remove', $method);

        $listeners = $dispatcher->getListeners('test_remove');

        $this->assertCount(1, $listeners);

        $dispatcher->removeListener('test_remove', $closure);

        $listeners = $dispatcher->getListeners('test_remove');

        $this->assertCount(0, $listeners);
    }

    public function testStopPropagation()
    {
        $dispatcher = new EventDispatcher();
        $dispatcher->addListener('test', $method = array(new Listener(), 'increment'), 0);
        $dispatcher->addListener('test', $closure = function (IncrementEvent $event) { $event->value++; }, 0);

        $incrementEvent = $dispatcher->dispatch('test', new IncrementEvent());

        $this->assertEquals(1, $incrementEvent->value);
    }

    public function testGetListeners()
    {
        $dispatcher = new EventDispatcher();
        $dispatcher->addListener('test_method', $method = array(new Listener(), 'someMethod'), 0);
        $dispatcher->addListener('test_closure', $closure = function (Event $event) { $event; }, 0);

        $this->assertCount(2, $dispatcher->getListeners());

        $this->assertEmpty($dispatcher->getListeners('not_exist'));
    }

    public function testPriority()
    {
        $closure0 = function (IncrementEvent $event) {
            if ($event->value === 0) {
                $event->value++;
            } else {
                throw new \Exception();
            }
        };

        $closure1 = function (IncrementEvent $event) {
            if ($event->value === 1) {
                $event->value++;
            } else {
                throw new \Exception();
            }
        };

        $dispatcher = new EventDispatcher();
        $dispatcher->addListener('test', $closure1, 1);
        $dispatcher->addListener('test', $closure0, 0);

        $incrementEvent = $dispatcher->dispatch('test', new IncrementEvent());

        $this->assertEquals(2, $incrementEvent->value);

        $this->setExpectedException('\Exception');

        $dispatcher = new EventDispatcher();
        $dispatcher->addListener('test', $closure0, 1);
        $dispatcher->addListener('test', $closure1, 0);

        $dispatcher->dispatch('test', new IncrementEvent());
    }

    public function testAddSubscriber()
    {
        $dispatcher = new EventDispatcher();
        $dispatcher->addSubscriber(new Subscriber());
        $event = $dispatcher->dispatch('test_string', new IncrementEvent());

        $this->assertEquals(1, $event->value);

        $event = $dispatcher->dispatch('test_array', new IncrementEvent());

        $this->assertEquals(1, $event->value);

        $event = $dispatcher->dispatch('test_array_array', new IncrementEvent());

        $this->assertEquals(0, $event->value);
    }

    public function testRemoveSubscriver()
    {
        $dispatcher = new EventDispatcher();
        $dispatcher->addSubscriber($subscriber = new Subscriber());

        $this->assertCount(1, $dispatcher->getListeners('test_string'));
        $this->assertCount(1, $dispatcher->getListeners('test_array'));
        $this->assertCount(2, $dispatcher->getListeners('test_array_array'));

        $dispatcher->removeSubscriber($subscriber);

        $this->assertCount(0, $dispatcher->getListeners('test_string'));
        $this->assertCount(0, $dispatcher->getListeners('test_array'));
        $this->assertCount(0, $dispatcher->getListeners('test_array_array'));
    }
}
