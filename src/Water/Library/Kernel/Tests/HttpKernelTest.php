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
        $kernel   = new HttpKernel(null, array());
        $response = $kernel->handle(Request::create('/'));
        $this->assertInstanceOf('\Exception', $response);

        $config   = include __DIR__ . '/Resource/app.config.php';
        $kernel   = new HttpKernel(null, $config);
        $response = $kernel->handle(Request::create('/'));
        $this->assertInstanceOf('\Water\Library\Http\Response', $response);


        $config   = include __DIR__ . '/Resource/app.config.php';
        $kernel   = new HttpKernel(null, $config);
        $response = $kernel->handle(Request::create('/notExist'));
        $this->assertInstanceOf('\Water\Library\Http\Response', $response);

        $config   = include __DIR__ . '/Resource/app.config.php';
        $config['framework']['error_handler'] = 'NotExistController::noAction';
        $kernel   = new HttpKernel(null, $config);
        $response = $kernel->handle(Request::create('/notExist'));
        $this->assertInstanceOf('\Water\Library\Http\Response', $response);

        $config   = include __DIR__ . '/Resource/app.config.php';
        unset($config['framework']['error_handler']);
        $kernel   = new HttpKernel(null, $config);
        $response = $kernel->handle(Request::create('/notExist'));
        $this->assertInstanceOf('\Exception', $response);
    }
}
