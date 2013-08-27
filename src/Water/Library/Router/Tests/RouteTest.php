<?php
/**
 * User: Ivan C. Sanches
 * Date: 27/08/13
 * Time: 17:09
 */
namespace Water\Library\Router\Tests;

use Water\Library\Router\Route;

/**
 * Class RouteTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class RouteTest extends \PHPUnit_Framework_TestCase 
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testConstruct()
    {
        $route = new Route('/', array('_controller' => 'IndexController'));

        $this->assertEquals('/', $route->getPath());
    }
}
