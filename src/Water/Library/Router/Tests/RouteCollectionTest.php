<?php
/**
 * User: Ivan C. Sanches
 * Date: 27/08/13
 * Time: 17:10
 */
namespace Water\Library\Router\Tests;

use Water\Library\Router\Route;
use Water\Library\Router\RouteCollection;

/**
 * Class RouteCollectionTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class RouteCollectionTest extends \PHPUnit_Framework_TestCase 
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testAddAndRemove()
    {
        $routes = new RouteCollection();
        $routes->add('home', new Route('/', array('_controller' => 'IndexController')));
        $routes->add('blog', new Route('/blog', array('_controller' => 'BlogController')));

        $this->assertCount(2, $routes->getRoutes());

        $routes->remove('blog');

        $this->assertCount(1, $routes->getRoutes());
    }
}
