<?php
/**
 * User: Ivan C. Sanches
 * Date: 01/10/13
 * Time: 09:39
 */
namespace Water\Library\DependencyInjection\Tests\Bag;

use Water\Library\DependencyInjection\Bag\ServiceBag;

/**
 * Class ServiceBagTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ServiceBagTest extends \PHPUnit_Framework_TestCase 
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testResolve()
    {
        $bag = new ServiceBag(null, array('index' => new \stdClass()));

        $this->assertEquals('index', $bag->resolve('#index'));
        $this->assertFalse($bag->resolve('#invalid#index'));
    }
}
