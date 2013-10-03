<?php
/**
 * User: Ivan C. Sanches
 * Date: 03/10/13
 * Time: 08:04
 */
namespace Water\Framework\Kernel\Tests\Bag;

use Water\Framework\Kernel\Bag\ModuleBag;

/**
 * Class ModuleBagTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ModuleBagTest extends \PHPUnit_Framework_TestCase 
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testModuleBag()
    {
        $bag = new ModuleBag();

        $this->assertInstanceOf('Water\Framework\Kernel\Bag\ModuleBag', $bag);
    }
}
