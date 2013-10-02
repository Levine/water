<?php
/**
 * User: Ivan C. Sanches
 * Date: 02/10/13
 * Time: 17:02
 */
namespace Water\Library\Bag\Tests\Type;

use Water\Library\Bag\SimpleBag;
use Water\Library\Bag\Type\ClassType;

/**
 * Class ClassTypeTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ClassTypeTest extends \PHPUnit_Framework_TestCase 
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testClassType()
    {
        $type = new ClassType('ArrayObject');

        $this->assertTrue($type->valid(new SimpleBag()));
        $this->assertFalse($type->valid(new \stdClass()));
        $this->assertEquals('ArrayObject', $type->getType());

        $type = new ClassType(new \ArrayObject());

        $this->assertTrue($type->valid(new SimpleBag()));
        $this->assertFalse($type->valid(new \stdClass()));
        $this->assertEquals('ArrayObject', $type->getType());
    }

    public function testClassTypeClassNotExistException()
    {
        $this->setExpectedException('Water\Library\Bag\Exception\InvalidArgumentException');
        new ClassType('NotExistClass');
    }

    public function testClassTypeInvalidTypeException()
    {
        $this->setExpectedException('Water\Library\Bag\Exception\InvalidArgumentException');
        new ClassType(0);
    }
}
