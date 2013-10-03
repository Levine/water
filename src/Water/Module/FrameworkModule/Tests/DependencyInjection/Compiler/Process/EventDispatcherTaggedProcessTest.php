<?php
/**
 * User: Ivan C. Sanches
 * Date: 03/10/13
 * Time: 17:16
 */
namespace Water\Module\FrameworkModule\Tests\DependencyInjection\Compiler\Process;
use Water\Module\FrameworkModule\DependencyInjection\Compiler\Process\EventDispatcherTaggedProcess;

/**
 * Class EventDispatcherTaggedProcessTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class EventDispatcherTaggedProcessTest extends \PHPUnit_Framework_TestCase 
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    private function getContainerBuilderMock($hasReturn = true)
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
            'get',
            'register',
            'hasDefinition',
            'setDefinitions',
            'addDefinition',
            'getDefinitions',
            'getDefinitionsByTag',
            'getDefinition',
            'registerExtension',
            'hasExtension',
            'setExtensions',
            'removeExtension',
            'addExtension',
            'getExtensions',
            'getExtension',
            'setCompiler',
            'getCompiler',
            'addProcess',
            'compile'
        );
        $container = $this->getMock(
            '\Water\Library\DependencyInjection\ContainerBuilderInterface',
            $methods
        );

        $container->expects($this->any())
                  ->method('has')
                  ->with($this->equalTo('dispatcher'))
                  ->will($this->returnValue($hasReturn));

        $definitionMock = $this->getMockBuilder('\Water\Library\DependencyInjection\Definition', array('addMethodCall'))
                               ->disableOriginalConstructor()
                               ->getMock();
        $container->expects($this->any())
                  ->method('getDefinition')
                  ->with($this->equalTo('dispatcher'))
                  ->will($this->returnValue($definitionMock));

        $container->expects($this->any())
                  ->method('getDefinitionsByTag')
                  ->with($this->equalTo('kernel.dispatcher_subscriber'))
                  ->will($this->returnValue(array($definitionMock, $definitionMock)));

        return $container;
    }

    public function testEventDispatcherTaggedProcess()
    {
        $process = new EventDispatcherTaggedProcess();

        $process->process($this->getContainerBuilderMock());

        $process = new EventDispatcherTaggedProcess();

        $process->process($this->getContainerBuilderMock(false));
    }
}
