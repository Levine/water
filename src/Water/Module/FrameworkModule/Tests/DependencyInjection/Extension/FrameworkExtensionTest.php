<?php
/**
 * User: Ivan C. Sanches
 * Date: 03/10/13
 * Time: 17:29
 */
namespace Water\Module\FrameworkModule\Tests\DependencyInjection\Extension;

use Water\Module\FrameworkModule\DependencyInjection\Extension\FrameworkExtension;

/**
 * Class FrameworkExtensionTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class FrameworkExtensionTest extends \PHPUnit_Framework_TestCase 
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    private function getContainerBuilderMock()
    {
        $container = $this->getMock('\Water\Library\DependencyInjection\ContainerBuilder');

        $definitionMock = $this->getMockBuilder(
                                   '\Water\Library\DependencyInjection\Definition',
                                   array('setArguments', 'addTag'))
                               ->disableOriginalConstructor()
                               ->getMock();
        $definitionMock->expects($this->any())
                       ->method('setArguments')
                       ->will($this->returnSelf());
        $container->expects($this->any())
                  ->method('register')
                  ->will($this->returnValue($definitionMock));

        return $container;
    }

    public function testFrameworkExtension()
    {
        $extension = new FrameworkExtension();
        $container = $this->getContainerBuilderMock();
        $container->expects($this->any())
                  ->method('getParameter')
                  ->with($this->equalTo('application_config'))
                  ->will($this->returnValue(
                      array('framework' => array('exception_action' => 'SomeController::someAction()'))
                  ));

        $extension->extend($container);
    }

    public function testDefaultExceptionListener()
    {
        $extension = new FrameworkExtension();
        $container = $this->getContainerBuilderMock();
        $container->expects($this->any())
                  ->method('getParameter')
                  ->with($this->equalTo('application_config'))
                  ->will($this->returnValue(array()));

        $extension->extend($container);
    }
}
