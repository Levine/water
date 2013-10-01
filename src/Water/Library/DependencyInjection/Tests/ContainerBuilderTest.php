<?php
/**
 * User: Ivan C. Sanches
 * Date: 30/09/13
 * Time: 16:15
 */
namespace Water\Library\DependencyInjection\Tests;

use Water\Library\DependencyInjection\ContainerBuilder;
use Water\Library\DependencyInjection\ContainerBuilderInterface;
use Water\Library\DependencyInjection\Definition;

/**
 * Class ContainerBuilderTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ContainerBuilderTest extends \PHPUnit_Framework_TestCase 
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    private function getCompilerMock()
    {
        $compiler = $this->getMock(
            '\Water\Library\DependencyInjection\Compiler\CompilerInterface',
            array('setProcesses', 'addProcess', 'getProcesses', 'compile')
        );

        $compiler->expects($this->any())
                 ->method('addProcess')
                 ->with($this->isInstanceOf('\Water\Library\DependencyInjection\Compiler\Process\ProcessInterface'));

        $compiler->expects($this->any())
                 ->method('compile')
                 ->with($this->isInstanceOf('Water\Library\DependencyInjection\ContainerBuilderInterface'));

        return $compiler;
    }

    private function getProcessMock()
    {
        $process = $this->getMock(
            '\Water\Library\DependencyInjection\Compiler\Process\ProcessInterface',
            array('process')
        );

        $process->expects($this->any())
                ->method('process')
                ->with($this->isInstanceOf('\Water\Library\DependencyInjection\ContainerBuilderInterface'));

        return $process;
    }

    public function testDefinition()
    {
        $container = new ContainerBuilder();
        $container->register('service', 'Service', array('arg0'))
                  ->addMethodCall('method', array('arg1'));

        $this->assertTrue($container->hasDefinition('service'));
        $this->assertCount(1, $container->getDefinitions());
        $this->assertInstanceOf('\Water\Library\DependencyInjection\Definition', $container->getDefinition('service'));

        $oldExpected = $container->getDefinitions()->toArray();
        $oldActual = $container->setDefinitions($expected = array(
            'service'           => new Definition('Service'),
            'other_service'     => new Definition('OtherService'),
            'some_service'      => new Definition('SomeService'),
        ));

        $this->assertEquals($expected, $container->getDefinitions()->toArray());
        $this->assertEquals($oldExpected, $oldActual);
    }

    public function testCompile()
    {
        $container = new ContainerBuilder();

        $this->assertInstanceOf('\Water\Library\DependencyInjection\Compiler\CompilerInterface', $container->getCompiler());

        $container->setCompiler($this->getCompilerMock());
        $container->addProcess($this->getProcessMock());
        $container->compile();
    }

    public function testGet()
    {
        $container = new ContainerBuilder();
        $container->addParameter('attr', 1);

        $container->register('service_with_constructor', '\Water\Library\DependencyInjection\Tests\Resource\Fixture\TestServiceWithConstructor')
                  ->setArguments(array('%attr%', '#service_without_constructor'));

        $container->register('service_without_constructor', '\Water\Library\DependencyInjection\Tests\Resource\Fixture\TestService')
                  ->addMethodCall('setAttr', array(2));

        $this->assertInstanceOf(
            '\Water\Library\DependencyInjection\Tests\Resource\Fixture\TestServiceWithConstructor',
            $container->get('service_with_constructor')
        );
        $this->assertEquals(2, $container->get('service_without_constructor')->attr);
    }
}
