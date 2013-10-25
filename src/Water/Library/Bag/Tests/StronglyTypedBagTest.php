<?php
/**
 * User: Ivan C. Sanches
 * Date: 02/10/13
 * Time: 17:09
 */
namespace Water\Library\Bag\Tests;

use Water\Library\Bag\StronglyTypedBag;

/**
 * Class StronglyTypedBagTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class StronglyTypedBagTest extends \PHPUnit_Framework_TestCase 
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function getIntegerTypeMock()
    {
        $type = $this->getMock('\Water\Library\Bag\Type\TypeInterface', array('getType', 'valid'));

        $type->expects($this->any())
             ->method('valid')
             ->will($this->returnCallback(function ($value) { return is_int($value); }));

        $type->expects($this->any())
             ->method('getType')
             ->will($this->returnValue('Integer'));

        return $type;
    }

    public function testConstructor()
    {
        $bag = new StronglyTypedBag($this->getIntegerTypeMock(), array(1, 2, 'index' => 3));

        $this->assertCount(3, $bag);

        $this->setExpectedException('\Water\Library\Bag\Exception\InvalidArgumentException');
        new StronglyTypedBag($this->getIntegerTypeMock(), array(1, 2, 'index' => 'value'));
    }

    public function testAppend()
    {
        $bag = new StronglyTypedBag($this->getIntegerTypeMock(), array(1, 2));
        $bag->append(3);

        $this->assertCount(3, $bag);

        $this->setExpectedException('\Water\Library\Bag\Exception\InvalidArgumentException');
        $bag->append('value');
    }

    public function testSet()
    {
        $bag = new StronglyTypedBag($this->getIntegerTypeMock(), array(1, 2));
        $bag->set('index', 3);

        $this->assertCount(3, $bag);

        $this->setExpectedException('\Water\Library\Bag\Exception\InvalidArgumentException');
        $bag->set('otherIndex', 'value');
    }

    public function testMerge()
    {
        $bag = new StronglyTypedBag($this->getIntegerTypeMock());
        $bag->fromArray(array(1, 2));
        $bag->merge(array(3));

        $this->assertCount(3, $bag);

        $this->setExpectedException('\Water\Library\Bag\Exception\InvalidArgumentException');
        $bag->merge(array('1'));
    }

    public function testFromArray()
    {
        $bag = new StronglyTypedBag($this->getIntegerTypeMock());
        $bag->fromArray(array(1, 2, 3));

        $this->assertCount(3, $bag);

        $this->setExpectedException('\Water\Library\Bag\Exception\InvalidArgumentException');
        $bag->fromArray(array(1, 2, 'index' => 'value'));
    }

    public function testArrayAccess()
    {
        $bag = new StronglyTypedBag($this->getIntegerTypeMock());
        $bag[]        = 1;
        $bag['index'] = 2;

        $this->assertCount(2, $bag);
        $this->assertEquals(2, $bag['index']);

        $this->setExpectedException('\Water\Library\Bag\Exception\InvalidArgumentException');
        $bag[] = 'value';
    }
}
