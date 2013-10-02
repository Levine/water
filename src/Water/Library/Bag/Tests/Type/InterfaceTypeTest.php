<?php
/**
 * User: Ivan C. Sanches
 * Date: 02/10/13
 * Time: 16:55
 */
namespace Water\Library\Bag\Tests\Type;
use Water\Library\Bag\Type\InterfaceType;

/**
 * Class InterfaceTypeTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class InterfaceTypeTest extends \PHPUnit_Framework_TestCase 
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testInterfaceType()
    {
        $type = new InterfaceType('\ArrayAccess');

        $this->assertTrue($type->valid(new \ArrayObject()));
        $this->assertFalse($type->valid(new \stdClass()));
        $this->assertEquals('\ArrayAccess', $type->getType());

        $this->setExpectedException('Water\Library\Bag\Exception\InvalidArgumentException');
        new InterfaceType('\stdClass');
    }
}
