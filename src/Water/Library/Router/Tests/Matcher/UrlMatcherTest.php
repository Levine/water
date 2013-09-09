<?php
/**
 * User: Ivan C. Sanches
 * Date: 09/09/13
 * Time: 14:53
 */
namespace Water\Library\Router\Tests\Matcher;
use Water\Library\Router\Matcher\UrlMatcher;
use Water\Library\Router\Route;
use Water\Library\Router\RouteCollection;

/**
 * Class UrlMatcherTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class UrlMatcherTest extends \PHPUnit_Framework_TestCase 
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
        $routes->add('home', $routeIndex = new Route('/', array('_controller' => 'IndexController::index()')));

        $urlMatcher = new UrlMatcher($routes);
        $this->assertArrayHasKey('name', $urlMatcher->match('/'));

        $this->assertFalse($urlMatcher->match('/blog'));
    }
}
