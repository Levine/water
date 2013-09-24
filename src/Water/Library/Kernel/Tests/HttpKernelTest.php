<?php
/**
 * User: Ivan C. Sanches
 * Date: 23/09/13
 * Time: 10:49
 */
namespace Water\Library\Kernel\Tests;

use Water\Library\EventDispatcher\EventDispatcher;
use Water\Library\Http\Request;
use Water\Library\Http\Response;
use Water\Library\Kernel\Event\ResponseFromControllerEvent;
use Water\Library\Kernel\EventListener\RouterListener;
use Water\Library\Kernel\HttpKernel;
use Water\Library\Kernel\KernelEvents;
use Water\Library\Kernel\Resolver\ControllerResolver;
use Water\Library\Router\Route;
use Water\Library\Router\RouteCollection;
use Water\Library\Router\Router;
use Water\Library\Kernel\Tests\Resource\RouterListener as TestRouterListener;

/**
 * Class HttpKernelTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class HttpKernelTest extends \PHPUnit_Framework_TestCase 
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    private function getHttpKernel()
    {
        $dispatcher = new EventDispatcher();

        $routes = new RouteCollection();
        $routes->add('home', new Route('/', array('_controller' => 'Water\Library\Kernel\Tests\Resource\IndexController::indexAction')));
        $routes->add('blog', new Route('/closure', array('_controller' => function () { return Response::create('Test'); })));

        $dispatcher->addSubscriber(new RouterListener(new Router($routes)));

        return new HttpKernel($dispatcher, new ControllerResolver());
    }

    public function testHandle()
    {
        $kernel   = $this->getHttpKernel();
        $response = $kernel->handle(Request::create('/'));

        $this->assertInstanceOf('\Water\Library\Http\Response', $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getContent());

        $kernel   = $this->getHttpKernel();
        $response = $kernel->handle(Request::create('/closure'));

        $this->assertInstanceOf('\Water\Library\Http\Response', $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getContent());

        $kernel   = $this->getHttpKernel();
        $response = $kernel->handle(Request::create(
            '/closure',
            'GET',
            array(),
            array('_controller' => function () { return Response::create('Test'); })
        ));

        $this->assertInstanceOf('\Water\Library\Http\Response', $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getContent());

        $kernel = $this->getHttpKernel();
        $kernel->getDispatcher()->addSubscriber(new TestRouterListener());

        $response = $kernel->handle(Request::create(
            '/closure',
            'GET',
            array(),
            array('_controller' => function () { return Response::create('Test'); })
        ));

        $this->assertInstanceOf('\Water\Library\Http\Response', $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getContent());
    }

    public function testHandleResponseFromController()
    {
        $kernel = $this->getHttpKernel();
        $kernel->getDispatcher()->addListener(
            KernelEvents::VIEW,
            function(ResponseFromControllerEvent $event) { $event->setResponse(Response::create('Test')); },
            64
        );

        $response = $kernel->handle(Request::create(
            '/test',
            'GET',
            array(),
            array('_controller' => function () { return true; })
        ));

        $this->assertInstanceOf('\Water\Library\Http\Response', $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getContent());

        $kernel = $this->getHttpKernel();
        $kernel->getDispatcher()->addListener(KernelEvents::VIEW, function() { return; }, 64);

        $response = $kernel->handle(Request::create(
            '/test',
            'GET',
            array(),
            array('_controller' => function () { return true; })
        ));

        $this->assertInstanceOf('\Water\Library\Kernel\Exception\LogicException', $response);
    }

    public function testHandleControllerNotFoundException()
    {
        $kernel   = new HttpKernel(new EventDispatcher(), new ControllerResolver());
        $response = $kernel->handle(Request::create('/', 'GET', array(), array()));

        $this->assertInstanceOf('\Water\Library\Kernel\Exception\ControllerNotFoundException', $response);
    }

    public function testHandleRouteNotFoundException()
    {
        $kernel = $this->getHttpKernel();
        $response = $kernel->handle(Request::create('/not/exist'));

        $this->assertInstanceOf('\Water\Library\Kernel\Exception\RouteNotFoundException', $response);
    }
}
