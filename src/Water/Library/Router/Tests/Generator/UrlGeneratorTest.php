<?php
/**
 * User: Ivan C. Sanches
 * Date: 09/09/13
 * Time: 16:42
 */
namespace Water\Library\Router\Tests\Generator;

use Water\Library\Router\Generator\UrlGenerator;
use Water\Library\Router\Route;
use Water\Library\Router\RouteCollection;

/**
 * Class UrlGeneratorTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class UrlGeneratorTest extends \PHPUnit_Framework_TestCase 
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testGenerate()
    {
        $routes = new RouteCollection();
        $routes->add('home', $routeIndex = new Route('/', array('_controller' => 'IndexController::index()')));
        $routes->add('blog', $routeIndex = new Route('/blog', array('_controller' => 'BlogController::index()')));

        $generator = new UrlGenerator($routes);

        $this->assertEquals('/', $generator->generate('home'));
        $this->assertEquals('/blog', $generator->generate('blog'));
        $this->assertEmpty($generator->generate('notExists'));
    }
}
