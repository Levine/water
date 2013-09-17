<?php
/**
 * User: Ivan C. Sanches
 * Date: 17/09/13
 * Time: 09:39
 */
namespace Water\Library\Kernel\Tests;
use Water\Library\Http\Request;
use Water\Library\Kernel\HttpKernel;

/**
 * Class HttpKernelTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class HttpKernelTest extends \PHPUnit_Framework_TestCase 
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testHandle()
    {
        $kernel   = new HttpKernel(null, include __DIR__ . '/Resource/app.config.php');
        $response = $kernel->handle(Request::create('/'));

        $this->assertInstanceOf('\Water\Library\Http\Response', $response);
    }
}
