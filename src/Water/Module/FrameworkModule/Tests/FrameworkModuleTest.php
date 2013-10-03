<?php
/**
 * User: Ivan C. Sanches
 * Date: 03/10/13
 * Time: 17:02
 */
namespace Water\Module\FrameworkModule\Tests;
use Water\Module\FrameworkModule\FrameworkModule;

/**
 * Class FrameworkModuleTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class FrameworkModuleTest extends \PHPUnit_Framework_TestCase 
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

        $container->expects($this->any())
                  ->method('addProcess')
                  ->with($this->isInstanceOf('Water\Library\DependencyInjection\Compiler\Process\ProcessInterface'));

        return $container;
    }

    public function testFrameworkModule()
    {
        $module = new FrameworkModule();

        $module->build($this->getContainerBuilderMock());
    }
}
