<?php
/**
 * User: Ivan C. Sanches
 * Date: 27/09/13
 * Time: 16:15
 */
namespace Water\Library\DependencyInjection\Tests;

use Water\Library\DependencyInjection\ServiceDefinition;

/**
 * Class ServiceDefinitionTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ServiceDefinitionTest extends \PHPUnit_Framework_TestCase 
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
        $def = new ServiceDefinition($class = '\Water\Library\DependencyInjection\Tests\Resource\Service', $args = array(1, 2));

        $this->assertEquals($class, $def->getClass());
        $this->assertEquals($args, $def->getArguments());
    }

    public function testSetArguments()
    {
        $class = '\Water\Library\DependencyInjection\Tests\Resource\Service';
        $args  = array(1, 2);

        $def = new ServiceDefinition($class);
        $def->addArgument($args[0])
            ->addArgument($args[1]);

        $this->assertEquals($class, $def->getClass());
        $this->assertEquals($args, $def->getArguments());

        $def = new ServiceDefinition($class);
        $def->setArguments($args);

        $this->assertEquals($class, $def->getClass());
        $this->assertEquals($args, $def->getArguments());
    }
}
