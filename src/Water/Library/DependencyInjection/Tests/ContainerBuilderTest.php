<?php
/**
 * User: Ivan C. Sanches
 * Date: 28/09/13
 * Time: 21:45
 */
namespace Water\Library\DependencyInjection\Tests;

use Water\Library\DependencyInjection\ContainerBuilder;

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

    public function testRegister()
    {
        $container = new ContainerBuilder();

        $container->register('service', '\Water\Library\DependencyInjection\Tests\Resource\Service');

        $this->assertTrue($container->hasServiceDefinition('service'));
        $this->assertNotNull($container->getServiceDefinition('service'));
    }

    public function testGet()
    {
        $container = new ContainerBuilder();

        $container->register('service', '\Water\Library\DependencyInjection\Tests\Resource\Service')
                  ->addArgument('arg1')
                  ->addArgument('arg2');

        $this->assertInstanceOf(
            '\Water\Library\DependencyInjection\Tests\Resource\Service',
            $container->get('service')
        );
    }

    public function testGetAndMethodCall()
    {
        $container = new ContainerBuilder();

        $container->register('service', '\Water\Library\DependencyInjection\Tests\Resource\Service')
                  ->addArgument('arg1')
                  ->addArgument('arg2')
                  ->addMethodCall('setArg1', array('1'))
                  ->addMethodCall('setArg2', array('2'));

        $service = $container->get('service');
        $this->assertEquals('1', $service->arg1);
        $this->assertEquals('2', $service->arg2);
    }

    public function testGetServicesByTag()
    {
        $container = new ContainerBuilder();

        $container->register('service1', 'Service1')->addTag('tag');
        $container->register('service2', 'Service2')->setTags(array('test', 'tag'));
        $container->register('service3', 'Service3')->addTag('tag');
        $container->register('service4', 'Service4')->addTag('test');

        $this->assertCount(3, $container->getServicesByTag('tag'));
    }

    public function testGetInvalidArgumentException()
    {
        $container = new ContainerBuilder();

        $container->register('service', '\NotExistService');

        $this->setExpectedException('\Water\Library\DependencyInjection\Exception\InvalidArgumentException');
        $container->get('service');
    }
}
