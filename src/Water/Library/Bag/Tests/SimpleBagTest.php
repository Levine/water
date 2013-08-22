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

    public function testConstruct()
    {
        $bag = new SimpleBag(null);
        $this->assertCount(0, $bag);

        $bag = new SimpleBag('');
        $this->assertCount(0, $bag);
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
