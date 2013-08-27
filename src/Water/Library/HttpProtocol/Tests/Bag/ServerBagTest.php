<?php
/**
 * User: Ivan C. Sanches
 * Date: 22/08/13
 * Time: 22:39
 */
namespace Water\Library\HttpProtocol\Tests\Bag;
use Water\Library\HttpProtocol\Bag\ServerBag;

/**
 * TestCase ServerBagTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ServerBagTest extends \PHPUnit_Framework_TestCase 
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testGetHeaders()
    {
        $_server = array(
            'HTTP_HOST'             => 'localhost',
            'HTTP_USER_AGENT'       => 'Water/1.0',
            'HTTP_ACCEPT'           => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'HTTP_ACCEPT_LANGUAGE'  => 'pt-BR,pt;q=0.8,en-US;q=0.6,en;q=0.4',
            'HTTP_ACCEPT_CHARSET'   => 'utf-8,ISO-8859-1;q=0.7,*;q=0.7',
            'CONTENT_LENGTH'        => 348,
            'SERVER_NAME'           => 'localhost',
            'SERVER_PORT'           => 80,
            'REMOTE_ADDR'           => '127.0.0.1',
            'SCRIPT_NAME'           => '',
            'SCRIPT_FILENAME'       => '',
            'SERVER_PROTOCOL'       => 'HTTP/1.1',
            'REQUEST_TIME'          => time(),
        );
        $server = new ServerBag($_server);

        $this->assertCount(6, $server->getHeaders());
        $this->assertCount(6, $server->getHeaders());
    }

    public function testAuthenticationHeaders()
    {
        $_server = array(
            'PHP_AUTH_USER' => 'pombaCorp',
            'PHP_AUTH_PW'   => 'pombaCorpPassword'
        );
        $server = new ServerBag($_server);

        $headers = $server->getHeaders();
        $this->assertEquals(
            'Basic '.base64_encode($server->get('PHP_AUTH_USER').':'.$server->get('PHP_AUTH_PW')),
            $headers['AUTHORIZATION']
        );

        $_server = array(
            'HTTP_AUTHORIZATION' => 'Basic '.base64_encode('pombaCorp:pombaCorpPassword')
        );
        $server = new ServerBag($_server);

        $headers = $server->getHeaders();
        $this->assertEquals('pombaCorp', $headers['PHP_AUTH_USER']);
        $this->assertEquals('pombaCorpPassword', $headers['PHP_AUTH_PW']);

        $_server = array(
            'REDIRECT_HTTP_AUTHORIZATION' => 'Basic '.base64_encode('pombaCorp:pombaCorpPassword')
        );
        $server = new ServerBag($_server);

        $headers = $server->getHeaders();
        $this->assertEquals('pombaCorp', $headers['PHP_AUTH_USER']);
        $this->assertEquals('pombaCorpPassword', $headers['PHP_AUTH_PW']);
    }
}
