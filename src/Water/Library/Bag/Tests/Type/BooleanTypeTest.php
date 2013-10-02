<?php
/**
 * User: Ivan C. Sanches
 * Date: 02/10/13
 * Time: 16:53
 */
namespace Water\Library\Bag\Tests\Type;

use Water\Library\Bag\Type\BooleanType;

/**
 * Class BooleanTypeTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class BooleanTypeTest extends \PHPUnit_Framework_TestCase 
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testBooleanType()
    {
        $type = new BooleanType();

        $this->assertTrue($type->valid(true));
        $this->assertTrue($type->valid(false));
        $this->assertFalse($type->valid('boolean'));
        $this->assertEquals('Boolean', $type->getType());
    }
}
