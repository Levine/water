<?php
/**
 * User: Ivan C. Sanches
 * Date: 30/09/13
 * Time: 16:08
 */
namespace Water\Library\DependencyInjection\Tests;
use Water\Library\DependencyInjection\Definition;

/**
 * Class DefinitionTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class DefinitionTest extends \PHPUnit_Framework_TestCase 
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
        $definition = new Definition('Service', array('arg'));
        $definition->addTag('service')
                   ->addMethodCall('someMethod', array('arg'));

        $this->assertInternalType('integer', $definition->hasTag('service'));
        $this->assertFalse($definition->hasTag('notExist'));
        $this->assertTrue($definition->hasMethodsCall());
    }
}
