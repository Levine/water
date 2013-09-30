<?php
/**
 * User: Ivan C. Sanches
 * Date: 30/09/13
 * Time: 16:15
 */
namespace Water\Library\DependencyInjection\Tests;

use Water\Library\DependencyInjection\ContainerBuilder;
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
}
