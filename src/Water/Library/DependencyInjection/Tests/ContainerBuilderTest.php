<?php
/**
 * User: Ivan C. Sanches
 * Date: 30/09/13
 * Time: 16:15
 */
namespace Water\Library\DependencyInjection\Tests;

use Water\Library\DependencyInjection\Compiler\Process\ExtensionProcess;
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

    private function getExtensionMock()
    {
        $extension = $this->getMock(
            '\Water\Library\DependencyInjection\Extension\ExtensionInterface',
            array('extend')
        );

        $extension->expects($this->any())
                  ->method('extend')
                  ->with($this->isInstanceOf('\Water\Library\DependencyInjection\ContainerBuilderInterface'))
                  ->will($this->returnCallback(function (ContainerBuilderInterface $container) {
                      $container->addParameter('extend', true);
                  }));

        return $extension;
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

        $service = new Definition('Service');
        $service->setTags(array('tag'));

        $otherService = new Definition('OtherService');
        $otherService->setTags(array('test'));

        $someService = new Definition('SomeService');
        $someService->setTags(array('tag', 'test', 'otherTag'));

        $oldActual = $container->setDefinitions($expected = array(
            'service'           => $service,
            'other_service'     => $otherService,
            'some_service'      => $someService,
        ));

        $this->assertEquals($expected, $container->getDefinitions()->toArray());
        $this->assertEquals($oldExpected, $oldActual);
        $this->assertCount(2, $container->getDefinitionsByTag('tag'));
        $this->assertCount(2, $container->getDefinitionsByTag('test'));
        $this->assertCount(1, $container->getDefinitionsByTag('otherTag'));
    }

    public function testCompile()
    {
        $container = new ContainerBuilder();

        $this->assertInstanceOf('\Water\Library\DependencyInjection\Compiler\CompilerInterface', $container->getCompiler());

        $container->setCompiler($this->getCompilerMock());
        $container->addProcess($this->getProcessMock());
        $container->compile();
    }

    public function testGetInstantiableClass()
    {
        $container = new ContainerBuilder();
        $container->addParameter('attr', 1);
        $container->addParameter('service_with_constructor.class', '\Water\Library\DependencyInjection\Tests\Resource\Fixture\TestServiceWithConstructor');
        $container->addParameter('service_without_constructor.class', '\Water\Library\DependencyInjection\Tests\Resource\Fixture\TestService');

        $container->register('service_with_constructor', '%service_with_constructor.class%')
                  ->setArguments(array('%attr%', '#service_without_constructor'));

        $container->register('service_without_constructor', '%service_without_constructor.class%')
                  ->addMethodCall('setAttr', array(2));

        $this->assertInstanceOf(
            '\Water\Library\DependencyInjection\Tests\Resource\Fixture\TestServiceWithConstructor',
            $container->get('service_with_constructor')
        );
        $this->assertEquals(2, $container->get('service_without_constructor')->attr);
    }

    public function testGetFactoryClass()
    {
        $container = new ContainerBuilder();
        $container->addParameter('attr', 1);
        $container->addParameter('service.class', '\Water\Library\DependencyInjection\Tests\Resource\Fixture\TestService');
        $container->addParameter('service_factory.class', 'Water\Library\DependencyInjection\Tests\Resource\Fixture\TestServiceFactory');
        $container->addParameter('service_factory.method', 'create');

        $container->register('service', '%service.class%')
                  ->setFactoryClass('%service_factory.class%')
                  ->setFactoryMethod('%service_factory.method%')
                  ->addArgument('%attr%');

        $this->assertInstanceOf(
            '\Water\Library\DependencyInjection\Tests\Resource\Fixture\TestService',
            $container->get('service')
        );
        $this->assertEquals(1, $container->get('service')->attr);
    }

    public function testGetNotExistServiceException()
    {
        $container = new ContainerBuilder();

        $this->setExpectedException('\Water\Library\DependencyInjection\Exception\NotExistServiceException');
        $container->get('notExist');
    }

    public function testGetInvalidClassDefinitionException()
    {
        $container = new ContainerBuilder();
        $container->register('service', 'NotExistClass');

        $this->setExpectedException('\InvalidArgumentException');
        $container->get('service');
    }

    public function testGetInsufficientArgumentsException()
    {
        $container = new ContainerBuilder();
        $container->register('service', '\Water\Library\DependencyInjection\Tests\Resource\Fixture\TestServiceWithConstructor');

        $this->setExpectedException('\InvalidArgumentException');
        $container->get('service');
    }

    public function testGetFactoryClassNotExistException()
    {
        $container = new ContainerBuilder();
        $container->addParameter('attr', 1);
        $container->addParameter('service.class', '\Water\Library\DependencyInjection\Tests\Resource\Fixture\TestService');
        $container->addParameter('service_factory.class', 'NotExistFactoryClass');
        $container->addParameter('service_factory.method', 'create');

        $container->register('service', '%service.class%')
                  ->setFactoryClass('%service_factory.class%')
                  ->setFactoryMethod('%service_factory.method%')
                  ->addArgument('%attr%');

        $this->setExpectedException('\InvalidArgumentException');
        $container->get('service');
    }

    public function testGetFactoryMethodNotExistException()
    {
        $container = new ContainerBuilder();
        $container->addParameter('attr', 1);
        $container->addParameter('service.class', '\Water\Library\DependencyInjection\Tests\Resource\Fixture\TestService');
        $container->addParameter('service_factory.class', 'Water\Library\DependencyInjection\Tests\Resource\Fixture\TestServiceFactory');
        $container->addParameter('service_factory.method', 'notExist');

        $container->register('service', '%service.class%')
                  ->setFactoryClass('%service_factory.class%')
                  ->setFactoryMethod('%service_factory.method%')
                  ->addArgument('%attr%');

        $this->setExpectedException('\InvalidArgumentException');
        $container->get('service');
    }

    public function testGetFactoryMethodNotStaticException()
    {
        $container = new ContainerBuilder();
        $container->addParameter('attr', 1);
        $container->addParameter('service.class', '\Water\Library\DependencyInjection\Tests\Resource\Fixture\TestService');
        $container->addParameter('service_factory.class', 'Water\Library\DependencyInjection\Tests\Resource\Fixture\TestServiceFactory');
        $container->addParameter('service_factory.method', 'notStaticCreate');

        $container->register('service', '%service.class%')
            ->setFactoryClass('%service_factory.class%')
            ->setFactoryMethod('%service_factory.method%')
            ->addArgument('%attr%');

        $this->setExpectedException('\InvalidArgumentException');
        $container->get('service');
    }

    public function testGetNotIsASpecifiedClassException()
    {
        $container = new ContainerBuilder();
        $container->addParameter('attr', 1);
        $container->addParameter('service.class', '\Water\Library\DependencyInjection\Tests\Resource\Fixture\TestServiceWithConstructor');
        $container->addParameter('service_factory.class', 'Water\Library\DependencyInjection\Tests\Resource\Fixture\TestServiceFactory');
        $container->addParameter('service_factory.method', 'create');

        $container->register('service', '%service.class%')
                  ->setFactoryClass('%service_factory.class%')
                  ->setFactoryMethod('%service_factory.method%')
                  ->addArgument('%attr%');

        $this->setExpectedException('\InvalidArgumentException');
        $container->get('service');
    }

    public function testPrepareArgumentsInvalidParameterException()
    {
        $container = new ContainerBuilder();

        $container->register('service', '\Water\Library\DependencyInjection\Tests\Resource\Fixture\TestServiceWithConstructor')
                  ->setArguments(array('%attr%', '#service_without_constructor'));

        $this->setExpectedException('\InvalidArgumentException');
        $container->get('service');
    }

    public function testPrepareArgumentsInvalidServiceException()
    {
        $container = new ContainerBuilder();
        $container->addParameter('attr', 1);

        $container->register('service', '\Water\Library\DependencyInjection\Tests\Resource\Fixture\TestServiceWithConstructor')
                  ->setArguments(array('%attr%', '#service_without_constructor'));

        $this->setExpectedException('\InvalidArgumentException');
        $container->get('service');
    }

    public function testExtension()
    {
        $container = new ContainerBuilder();
        $container->registerExtension('test1', $this->getExtensionMock());
        $container->registerExtension('test2', $this->getExtensionMock());

        $this->assertTrue($container->hasExtension('test1'));
        $this->assertCount(2, $container->getExtensions());

        $container->removeExtension('test1');

        $this->assertFalse($container->hasExtension('test1'));
        $this->assertCount(1, $container->getExtensions());

        $container->setExtensions(array(
            'test1' => $this->getExtensionMock(),
            'test2' => $this->getExtensionMock(),
        ));

        $this->assertCount(2, $container->getExtensions());
        $this->assertEquals($this->getExtensionMock(), $container->getExtension('test1'));
    }

    public function testExtensionProcess()
    {
        $container = new ContainerBuilder();
        $container->addProcess(new ExtensionProcess());
        $container->registerExtension('test', $this->getExtensionMock());
        $container->compile();

        $this->assertEquals(true, $container->getParameter('extend'));
    }
}
