<?php
/**
 * User: Ivan C. Sanches
 * Date: 11/09/13
 * Time: 14:56
 */
namespace Water\Library\Router\Tests;

use Water\Library\Router\Route;
use Water\Library\Router\RouteCollection;
use Water\Library\Router\Router;

/**
 * Class RouterTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class RouterTest extends \PHPUnit_Framework_TestCase 
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testMatch()
    {
        $routes = new RouteCollection();
        $routes->add('home', new Route('/', $expectedHomeResource = array('_controller' => 'IndexController')));
        $routes->add('blog', new Route('/blog', $expectedBlogResource = array('_controller' => 'BlogController')));

        $router = new Router($routes);

        $this->assertEquals($expectedHomeResource, $router->match('/'));
        $this->assertEquals($expectedBlogResource, $router->match('/blog'));

        $this->setExpectedException('\InvalidArgumentException');

        $router = new Router($routes, array('matcher_class' => 'NotExistClass'));
        $router->match('/');
    }

    public function testGenerate()
    {
        $routes = new RouteCollection();
        $routes->add('home', new Route('/', array('_controller' => 'IndexController')));
        $routes->add('blog', new Route('/blog', array('_controller' => 'BlogController')));

        $router = new Router($routes);

        $this->assertEquals('/', $router->generate('home'));
        $this->assertEquals('/blog', $router->generate('blog'));

        $this->setExpectedException('\InvalidArgumentException');

        $router = new Router($routes, array('generator_class' => 'NotExistClass'));
        $router->generate('home');
    }
}
