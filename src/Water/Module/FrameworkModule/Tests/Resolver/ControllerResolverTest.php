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

    private function getContainerMock($moduleExist = true)
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
                  ->method('get')
                  ->with($this->equalTo('modules'))
                  ->will($this->returnValue($this->getModuleBagMock($moduleExist)));

        return $container;
    }

    private function getModuleBagMock($moduleExist)
    {
        $bag = $this->getMockBuilder('\Water\Framework\Kernel\Bag\ModuleBag')
                    ->disableOriginalConstructor()
                    ->setMethods(array('has', 'get'))
                    ->getMock();

        $bag->expects($this->any())
            ->method('has')
            ->with($this->equalTo('SomeModule'))
            ->will($this->returnValue($moduleExist));

        $bag->expects($this->any())
            ->method('get')
            ->will($this->returnValue($this->getMockForAbstractClass('\Water\Framework\Kernel\Module\Module')));

        return $bag;
    }

    public function testBaseResolver()
    {
        $resolver = new ControllerResolver($this->getContainerMock(true));
        $controller = $resolver->getController(Request::create(
            '/',
            'GET',
            array(),
            array('_controller' => '\Water\Module\FrameworkModule\Tests\Resolver\Resource\TestController::indexAction')
        ));

        $this->assertAttributeInstanceOf('\Water\Library\DependencyInjection\ContainerInterface', 'container', $controller[0]);
    }

    public function testResolverShortName()
    {
        $resolver = new ControllerResolver($this->getContainerMock(true));

        $this->setExpectedException('Water\Library\Kernel\Exception\InvalidArgumentException');
        $resolver->getController(Request::create(
            '/',
            'GET',
            array(),
            array('_controller' => 'SomeModule:IndexController:indexAction')
        ));
    }

    public function testModuleNotExist()
    {
        $resolver = new ControllerResolver($this->getContainerMock(false));

        $this->setExpectedException('Water\Library\Kernel\Exception\InvalidArgumentException');
        $resolver->getController(Request::create(
            '/',
            'GET',
            array(),
            array('_controller' => 'SomeModule:IndexController:indexAction')
        ));
    }

    public function testInvalidControllerName()
    {
        $resolver = new ControllerResolver($this->getContainerMock(true));

        $this->setExpectedException('Water\Library\Kernel\Exception\InvalidArgumentException');
        $resolver->getController(Request::create(
            '/',
            'GET',
            array(),
            array('_controller' => 'SomeModule::IndexController::indexAction')
        ));
    }
}
