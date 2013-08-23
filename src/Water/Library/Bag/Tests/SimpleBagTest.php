<?php
/**
 * User: Ivan C. Sanches
 * Date: 21/08/13
 * Time: 23:04
 */
namespace Water\Library\Bag\Tests;
use Water\Library\Bag\SimpleBag;

/**
 * TestCase SimpleBagTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class SimpleBagTest extends \PHPUnit_Framework_TestCase 
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testOffsetGet()
    {
        $bag = new SimpleBag(array('index' => 'value'));

        $this->assertEquals('value', $bag->offsetGet('index'));
        $this->assertNull($bag->offsetGet('notExistsIndex'));
    }

    public function testGetAndSet()
    {
        $bag = new SimpleBag(array('index' => 'value'));

        $this->assertEquals('value', $bag->get('index'));
        $this->assertNull($bag->get('notExistsIndex'));
        $this->assertEquals($expected = 'expectedValue', $bag->get('notExistsIndex', $expected));

        $bag->set('newIndex', $expected = 'newValue');
        $this->assertEquals($expected, $bag->get('newIndex'));
    }

    public function testFromArrayAndFromString()
    {
        $bag = new SimpleBag($expected1 = array('index' => 'value'));

        $old = $bag->fromArray($expected2 = array('otherIndex' => 'otherValue'));
        $this->assertEquals($expected1, $old);
        $this->assertEquals($expected2, (array) $bag);

        $old = $bag->fromString(http_build_query($expected1));
        $this->assertEquals($expected2, $old);
        $this->assertEquals($expected1, (array) $bag);
    }

    public function testToArray()
    {
        $bag = new SimpleBag(array('index' => 'value'));

        $this->assertInternalType('array', $bag->toArray());
    }

    public function testToString()
    {
        $bag = new SimpleBag(array('index' => 'value'));

        $this->assertInternalType('string', $bag->toString());
        $this->assertInternalType('string', (string) $bag);
    }
}
