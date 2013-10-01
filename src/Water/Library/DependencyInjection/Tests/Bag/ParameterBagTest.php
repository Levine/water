<?php
/**
 * User: Ivan C. Sanches
 * Date: 01/10/13
 * Time: 09:18
 */
namespace Water\Library\DependencyInjection\Tests\Bag;

use Water\Library\DependencyInjection\Bag\ParameterBag;

/**
 * Class ParameterBagTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ParameterBagTest extends \PHPUnit_Framework_TestCase 
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
        $bag = new ParameterBag();

        $this->assertEquals('index', $bag->resolve('%index%'));
        $this->assertFalse($bag->resolve('%invalid%index%'));
    }
}
