<?php
/**
 * User: Ivan C. Sanches
 * Date: 27/08/13
 * Time: 15:14
 */
namespace Water\Library\HttpProtocol\Tests;
use Water\Library\HttpProtocol\Response;

/**
 * Class ResponseTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ResponseTest extends \PHPUnit_Framework_TestCase 
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testSend()
    {
        $response = Response::create('Test Case', 200, array('Foo' => 'Bar'));

        ob_start();
        $response->send();
        $content = ob_get_clean();

        $this->assertNotEmpty($content);
    }

    public function testToString()
    {
        $response = Response::create('Test Case', 200, array('Foo' => 'Bar'));
        $toString = "HTTP/1.1 200 OK\r\n"
                  . "Foo: Bar\r\n"
                  . "\r\n"
                  . "Test Case";

        $this->assertEquals($toString, (string) $response);
    }
}
