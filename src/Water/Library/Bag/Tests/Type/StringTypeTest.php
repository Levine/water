<?php
/**
 * User: Ivan C. Sanches
 * Date: 02/10/13
 * Time: 16:50
 */
namespace Water\Library\Bag\Tests\Type;
use Water\Library\Bag\Type\StringType;

/**
 * Class StringTypeTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class StringTypeTest extends \PHPUnit_Framework_TestCase 
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testStringType()
    {
        $type = new StringType();

        $this->assertTrue($type->valid('string'));
        $this->assertFalse($type->valid(0));
        $this->assertEquals('String', $type->getType());
    }
}
