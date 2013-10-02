<?php
/**
 * User: Ivan C. Sanches
 * Date: 02/10/13
 * Time: 16:51
 */
namespace Water\Library\Bag\Tests\Type;

use Water\Library\Bag\Type\ArrayType;

/**
 * Class ArrayTypeTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ArrayTypeTest extends \PHPUnit_Framework_TestCase 
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testArrayType()
    {
        $type = new ArrayType();

        $this->assertTrue($type->valid(array('index', 'otherIndex')));
        $this->assertFalse($type->valid('array'));
        $this->assertEquals('Array', $type->getType());
    }
}
