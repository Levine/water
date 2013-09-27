<?php
/**
 * User: Ivan C. Sanches
 * Date: 27/09/13
 * Time: 15:55
 */
namespace Water\Library\DependencyInjection\Tests;

use Water\Library\DependencyInjection\Container;
use Water\Library\DependencyInjection\Tests\Resource\Service;

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

    public function testConstruct()
    {
        $container = new Container();

        $this->assertInstanceOf('Water\Library\DependencyInjection\Container', $container);
    }

    public function testParameter()
    {
        $container = new Container();
        $container->addParameter('index', 'value')
                  ->addParameter('otherIndex', 'otherValue');

        $this->assertEquals('value', $container->getParameter('index'));
        $this->assertEquals('otherValue', $container->getParameter('otherIndex'));
        $this->assertNull($container->getParameter('notExistParameter'));

        $container->setParameters($paramenters = array('index' => 'value'));

        $this->assertEquals($paramenters, (array) $container->getParameters());
    }

    public function testHasAndSetAndGet()
    {
        $container = new Container(array('index' => 'value'));
        $container->set('service', $service = new Service(1, 2));

        $this->assertTrue($container->has('service'));
        $this->assertFalse($container->has('notExistService'));
        $this->assertEquals($container, $container->get('service_container'));
        $this->assertEquals($service, $container->get('service'));
        $this->assertNull($container->get('notExistService'));

        $this->setExpectedException('\Water\Library\DependencyInjection\Exception\NotAllowOverrideException');
        $container->set('service', null);
    }
}
