<?php
/**
 * User: Ivan C. Sanches
 * Date: 02/10/13
 * Time: 16:54
 */
namespace Water\Library\Bag\Tests\Type;

use Water\Library\Bag\Type\IntegerType;

/**
 * Class IntegerTypeTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class IntegerTypeTest extends \PHPUnit_Framework_TestCase 
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testIntegerType()
    {
        $type = new IntegerType();

        $this->assertTrue($type->valid(0));
        $this->assertFalse($type->valid('1'));
        $this->assertEquals('Integer', $type->getType());
    }
}
