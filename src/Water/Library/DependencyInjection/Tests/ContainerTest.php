<?php
/**
 * User: Ivan C. Sanches
 * Date: 30/09/13
 * Time: 14:44
 */
namespace Water\Library\DependencyInjection\Tests;
use Water\Library\DependencyInjection\Container;

/**
 * Class ContainerTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ContainerTest extends \PHPUnit_Framework_TestCase 
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testParameters()
    {
        $container = new Container($parameter = array(
            'index'      => 'value',
            'otherIndex' => 'otherValue',
        ));

        $this->assertTrue($container->hasParameter('index'));
        $this->assertFalse($container->hasParameter('notExist'));
        $this->assertEquals('value', $container->getParameter('index'));
        $this->assertEquals($parameter, $container->getParameters()->toArray());

        $parameter['someIndex'] = 'someValue';
        $container->addParameter('someIndex', 'someValue');

        $this->assertTrue($container->hasParameter('someIndex'));
        $this->assertEquals('someValue', $container->getParameter('someIndex'));

        $oldParameters = $container->setParameters($newParameters = array('index' => 'value'));

        $this->assertEquals($oldParameters, $parameter);
        $this->assertEquals($newParameters, $container->getParameters()->toArray());
    }

    public function testServices()
    {
        $container = new Container();
        $container->addService('service', $service = function () { return true; });

        $this->assertTrue($container->hasService('service'));
        $this->assertEquals($service, $container->getService('service'));
        $this->assertEquals(
            $expected = array('service_container' => $container,'service' => $service),
            $container->getServices()->toArray()
        );

        $oldServices = $container->setServices(array(
            'service'       => $service,
            'other_service' => function () { return false; },
        ));

        $this->assertTrue($container->hasService('other_service'));
        $this->assertEquals($oldServices, $expected);
    }
}
