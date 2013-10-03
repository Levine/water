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

        $extension->extend($this->getContainerBuilderMock());
    }
}
