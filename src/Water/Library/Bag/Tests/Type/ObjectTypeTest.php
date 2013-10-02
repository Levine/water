<?php
/**
 * User: Ivan C. Sanches
 * Date: 02/10/13
 * Time: 17:47
 */
namespace Water\Library\Bag\Tests\Type;

use Water\Library\Bag\SimpleBag;
use Water\Library\Bag\Type\ObjectType;

/**
 * Class ObjectTypeTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ObjectTypeTest extends \PHPUnit_Framework_TestCase 
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }
    public function testObjectType()
    {
        $type = new ObjectType();

        $this->assertTrue($type->valid(new SimpleBag()));
        $this->assertFalse($type->valid('value'));
        $this->assertEquals('Object', $type->getType());
    }

}
