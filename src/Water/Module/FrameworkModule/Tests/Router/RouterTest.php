<?php
/**
 * User: Ivan C. Sanches
 * Date: 03/10/13
 * Time: 15:53
 */
namespace Water\Module\FrameworkModule\Tests\Router;

use Water\Module\FrameworkModule\Router\Router;

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

    private function getContainerMock()
    {
        $methods = array(
            'hasParameter',
            'setParameters',
            'addParameter',
            'getParameters',
            'getParameter',
            'has',
            'setServices',
            'add',
            'getServices',
            'get'
        );
        $container = $this->getMock(
            '\Water\Library\DependencyInjection\ContainerInterface',
            $methods
        );

        $container->expects($this->any())
                  ->method('getParameter')
                  ->with($this->equalTo('application_config'))
                  ->will($this->returnValue(include __DIR__ . '/Resource/application.config.php'));

        return $container;
    }

    public function testRouter()
    {
        $router = new Router($this->getContainerMock());

        $this->assertCount(1, $router->getRoutes());
    }
}
