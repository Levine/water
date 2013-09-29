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

    public function testGetWithReferences()
    {
        $container = new ContainerBuilder();

        $container->addParameter('attr', 'value');

        $container->register('service', '\Water\Library\DependencyInjection\Tests\Resource\Service')
                  ->addArgument('arg1')
                  ->addArgument('arg2');

        $container->register('service_with_reference', '\Water\Library\DependencyInjection\Tests\Resource\ServiceWithReference')
                  ->addArgument('#service')
                  ->addArgument('%attr%');

        $serviceWithReference = $container->get('service_with_reference');
        $this->assertInstanceOf(
            '\Water\Library\DependencyInjection\Tests\Resource\Service',
            $serviceWithReference->service
        );
        $this->assertEquals('value', $serviceWithReference->attr);

        $container = new ContainerBuilder();

        $container->addParameter('attr', 'value');

        $container->register('service_with_reference', '\Water\Library\DependencyInjection\Tests\Resource\ServiceWithReference')
                  ->addArgument('#service')
                  ->addArgument('%attr%');

        $container->register('service', '\Water\Library\DependencyInjection\Tests\Resource\Service')
                  ->addArgument('arg1')
                  ->addArgument('arg2');

        $serviceWithReference = $container->get('service_with_reference');
        $this->assertInstanceOf(
            '\Water\Library\DependencyInjection\Tests\Resource\Service',
            $serviceWithReference->service
        );
        $this->assertEquals('value', $serviceWithReference->attr);
    }

    public function testGetWithReferenceInvalidArgumentException()
    {
        $container = new ContainerBuilder();

        $container->addParameter('attr', 'value');

        $container->register('service_with_reference', '\Water\Library\DependencyInjection\Tests\Resource\ServiceWithReference')
                  ->addArgument('#service')
                  ->addArgument('%attr%');

        $this->setExpectedException(
            '\Water\Library\DependencyInjection\Exception\InvalidArgumentException',
            'The service specified by id "service", not exist. '
            . 'It was called when trying to create "\Water\Library\DependencyInjection\Tests\Resource\ServiceWithReference" '
            . 'specified by id "service_with_reference".'
        );
        $container->get('service_with_reference');
    }

    public function testGetServicesByTag()
    {
        $container = new ContainerBuilder();

        $container->register('service1', 'Service1')->addTag('tag');
        $container->register('service2', 'Service2')->setTags(array('test', 'tag'));
        $container->register('service3', 'Service3')->addTag('tag');
        $container->register('service4', 'Service4')->addTag('test');

        $this->assertCount(3, $container->getServiceIdsByTag('tag'));
    }

    public function testGetInvalidArgumentException()
    {
        $container = new ContainerBuilder();

        $container->register('service', '\NotExistService');

        $this->setExpectedException('\Water\Library\DependencyInjection\Exception\InvalidArgumentException');
        $container->get('service');
    }
}
