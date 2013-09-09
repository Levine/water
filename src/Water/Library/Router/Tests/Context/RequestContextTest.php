<?php
/**
 * User: Ivan C. Sanches
 * Date: 09/09/13
 * Time: 16:07
 */
namespace Water\Library\Router\Tests\Context;

use Water\Library\Http\Request;
use Water\Library\Router\Context\RequestContext;

/**
 * Class RequestContextTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class RequestContextTest extends \PHPUnit_Framework_TestCase 
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
        $context = new RequestContext(
            $path = '/path?arg=value',
            $method = 'POST',
            $host = 'pombacorp.com',
            $scheme = 'https',
            $port = 443
        );

        $this->assertEquals('/path', $context->getPath());
        $this->assertEquals('arg=value', $context->getQuery());
        $this->assertEquals($method, $context->getMethod());
        $this->assertEquals($host, $context->getHost());
        $this->assertEquals($scheme, $context->getScheme());
        $this->assertEquals($port, $context->getPort());

        $context = new RequestContext(
            $path = 'path',
            $method = 'POST',
            $host = 'pombacorp.com',
            $scheme = 'https',
            $port = 443
        );

        $this->assertEquals('/path', $context->getPath());
        $this->assertEquals($method, $context->getMethod());
        $this->assertEquals($host, $context->getHost());
        $this->assertEquals($scheme, $context->getScheme());
        $this->assertEquals($port, $context->getPort());
    }

    public function testFromRequest()
    {
        $context = new RequestContext();
        $context->fromRequest(Request::create('/path?arg=value'));

        $this->assertEquals('/path', $context->getPath());
        $this->assertEquals('arg=value', $context->getQuery());
        $this->assertEquals('GET', $context->getMethod());
        $this->assertEquals('localhost', $context->getHost());
        $this->assertEquals('http', $context->getScheme());
        $this->assertEquals(80, $context->getPort());
    }
}
