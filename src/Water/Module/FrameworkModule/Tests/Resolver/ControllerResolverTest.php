<?php
/**
 * User: Ivan C. Sanches
 * Date: 03/10/13
 * Time: 16:27
 */
namespace Water\Module\FrameworkModule\Tests\Resolver;

use Water\Library\Http\Request;
use Water\Module\FrameworkModule\Resolver\ControllerResolver;

/**
 * Class ControllerResolverTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ControllerResolverTest extends \PHPUnit_Framework_TestCase 
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

        return $container;
    }

    public function testResolver()
    {
        $resolver = new ControllerResolver($this->getContainerMock());
        $controller = $resolver->getController(Request::create(
            '/',
            'GET',
            array(),
            array('_controller' => '\Water\Module\FrameworkModule\Tests\Resolver\Resource\TestController::indexAction')
        ));

        $this->assertAttributeInstanceOf('\Water\Library\DependencyInjection\ContainerInterface', 'container', $controller[0]);
    }
}
