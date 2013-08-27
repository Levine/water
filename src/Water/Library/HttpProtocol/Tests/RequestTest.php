<?php
/**
 * User: Ivan C. Sanches
 * Date: 22/08/13
 * Time: 14:37
 */
namespace Water\Library\HttpProtocol\Tests;
use Water\Library\HttpProtocol\Request;

/**
 * Class RequestTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class RequestTest extends \PHPUnit_Framework_TestCase 
{
    /**
     * @var array Original values from Globals variables.
     */
    private $originalGlobals = array();

    protected function setUp()
    {
        $this->originalGlobals = array(
            'get'       => $_GET,
            'post'      => $_POST,
            'cookie'    => $_COOKIE,
            'files'     => $_FILES,
            'server'    => $_SERVER
        );

        $_GET    = array('getIndex' => 'getValue');
        $_POST   = array('postIndex' => 'postValue');
        $_COOKIE = array('cookieIndex' => 'cookieValue');
        $_FILES  = array('fileIndex' => 'fileValue');
        $_SERVER = array(
            'REQUEST_METHOD' => 'POST'
        );

        parent::setUp();
    }

    protected function tearDown()
    {
        $_GET    = $this->originalGlobals['get'];
        $_POST   = $this->originalGlobals['post'];
        $_COOKIE = $this->originalGlobals['cookie'];
        $_FILES  = $this->originalGlobals['files'];
        $_SERVER = $this->originalGlobals['server'];

        parent::tearDown();
    }

    public function testCreateFromGlobals()
    {
        $request = Request::createFromGlobals();

        $this->assertEquals('getValue', $request->get('getIndex'));
        $this->assertEquals('postValue', $request->get('postIndex'));
        $this->assertEquals('cookieValue', $request->get('cookieIndex'));
        $this->assertEquals('fileValue', $request->get('fileIndex'));
    }

    public function testCreate()
    {
        $url     = '/some/path';
        $method  = 'GET';
        $get     = array('index' => 'value');
        $cookie  = array('cookieIndex' => 'cookieValue');
        $files   = array('fileIndex' => 'fileValue');
        $server  = array();
        $content = '';

        $request = Request::create($url, $method, $get, $cookie, $files, $server, $content);

        $this->assertEquals('value', $request->get('index'));

        $url     = 'http://localhost';
        $request = Request::create($url);

        $this->assertFalse($request->isSecure());

        $url     = 'http://localhost';
        $post    = array('postIndex' => 'postValue');
        $request = Request::create($url, 'post', $post);

        $this->assertFalse($request->isSecure());
        $this->assertEquals('postValue', $request->get('postIndex'));

        $url     = 'https://pombaCorp:pombaCorpPassword@localhost:555/some/path?index=value';
        $request = Request::create($url);

        $this->assertTrue($request->isSecure());
        $this->assertEquals('value', $request->get('index'));
        $this->assertEquals('localhost', $request->getHost());
    }

    public function testOverrideGlobals()
    {
        $url     = '/some/path';
        $method  = 'GET';
        $get     = array('index' => 'value');
        $cookie  = array('cookieIndex' => 'cookieValue');
        $files   = array('fileIndex' => 'fileValue');
        $server  = array();
        $content = '';
        $request = Request::create($url, $method, $get, $cookie, $files, $server, $content);
        $request->overrideGlobals();

        $this->assertEquals($get, $_GET);
        $this->assertEquals(array(), $_POST);
        $this->assertEquals($cookie, $_COOKIE);
        $this->assertEquals($files, $_FILES);
    }

    public function testGetScheme()
    {
        $url     = '/some/path';
        $request = Request::create($url);

        $this->assertEquals('http', $request->getScheme());

        $url     = 'http://localhost/some/path';
        $request = Request::create($url);

        $this->assertEquals('http', $request->getScheme());

        $url     = 'https://pombaCorp:pombaCorpPassword@localhost:555/some/path';
        $request = Request::create($url);

        $this->assertEquals('https', $request->getScheme());
    }

    public function testGetUser()
    {
        $url     = 'http://localhost/some/path';
        $request = Request::create($url);

        $this->assertEquals('', $request->getUser());

        $url     = 'https://pombaCorp:pombaCorpPassword@localhost:555/some/path';
        $request = Request::create($url);

        $this->assertEquals('pombaCorp', $request->getUser());
    }

    public function testGetPassword()
    {
        $url     = 'http://localhost/some/path';
        $request = Request::create($url);

        $this->assertEquals('', $request->getPassword());

        $url     = 'https://pombaCorp:pombaCorpPassword@localhost:555/some/path';
        $request = Request::create($url);

        $this->assertEquals('pombaCorpPassword', $request->getPassword());
    }

    public function testGetHost()
    {
        $url     = 'http://localhost/some/path';
        $request = Request::create($url);

        $this->assertEquals('localhost', $request->getHost());

        $url     = 'https://pombaCorp:pombaCorpPassword@localhost:555/some/path';
        $request = Request::create($url);

        $this->assertEquals('localhost', $request->getHost());
    }

    public function testGetPort()
    {
        $url     = 'http://localhost/some/path';
        $request = Request::create($url);

        $this->assertEquals(80, $request->getPort());

        $url     = 'https://localhost/some/path';
        $request = Request::create($url);

        $this->assertEquals(443, $request->getPort());

        $url     = 'https://pombaCorp:pombaCorpPassword@localhost:555/some/path';
        $request = Request::create($url);

        $this->assertEquals(555, $request->getPort());
    }

    public function testGetPath()
    {
        $url     = '/some/path';
        $request = Request::create($url);

        $this->assertEquals('/some/path', $request->getPath());

        $url     = '/some/path?some=query';
        $request = Request::create($url);

        $this->assertEquals('/some/path', $request->getPath());
    }

    public function testGetQuery()
    {
        $url     = '/some/path';
        $request = Request::create($url);

        $this->assertEquals('', $request->getQuery());

        $url     = '/some/path?some=query';
        $request = Request::create($url);

        $this->assertEquals('some=query', $request->getQuery());
    }

    public function testGetSchemeHost()
    {
        $url     = 'http://localhost/some/path';
        $request = Request::create($url);

        $this->assertEquals('http://localhost', $request->getSchemeHost());

        $url     = 'https://pombaCorp:pombaCorpPassword@localhost:555/some/path';
        $request = Request::create($url);

        $this->assertEquals('https://pombaCorp:pombaCorpPassword@localhost:555', $request->getSchemeHost());
    }

    public function testGetUrl()
    {
        $url     = 'http://localhost/some/path';
        $request = Request::create($url);

        $this->assertEquals($url, $request->getUrl());

        $url     = 'https://pombaCorp:pombaCorpPassword@localhost:555/some/path?index=value';
        $request = Request::create($url);

        $this->assertEquals($url, $request->getUrl());
    }

    public function testGet()
    {
        $request = new Request(
            array('getIndex' => 'getValue'),
            array('postIndex' => 'postValue'),
            array('cookieIndex' => 'cookieValue'),
            array('fileIndex' => 'fileValue'),
            array(),
            ''
        );

        $this->assertEquals('getValue', $request->get('getIndex'));
        $this->assertEquals('postValue', $request->get('postIndex'));
        $this->assertEquals('cookieValue', $request->get('cookieIndex'));
        $this->assertEquals('fileValue', $request->get('fileIndex'));
    }

    public function testIsSecure()
    {
        $request = Request::createFromGlobals();

        $this->assertFalse($request->isSecure());

        $_SERVER['HTTPS'] = 'on';
        $request = Request::createFromGlobals();

        $this->assertTrue($request->isSecure());
    }

    public function testIsMethod()
    {
        $_SERVER = array('REQUEST_METHOD' => 'GET');
        $request = Request::createFromGlobals();

        $this->assertTrue($request->isMethod('get'));
        $this->assertTrue($request->isMethod('GET'));
        $this->assertFalse($request->isMethod('POST'));
    }

    public function testIsGetAndIsPost()
    {
        $_SERVER = array('REQUEST_METHOD' => 'GET');
        $request = Request::createFromGlobals();

        $this->assertTrue($request->isGet());
        $this->assertFalse($request->isPost());

        $_SERVER = array('REQUEST_METHOD' => 'POST');
        $request = Request::createFromGlobals();

        $this->assertTrue($request->isPost());
        $this->assertFalse($request->isGet());
    }

    public function testIsXmlHttpRequestAndIsAjax()
    {
        $request = Request::createFromGlobals();

        $this->assertFalse($request->isXmlHttpRequest());
        $this->assertFalse($request->isAjax());

        $_SERVER = array('X-Requested-With' => 'XMLHttpRequest');
        $request = Request::createFromGlobals();

        $this->assertTrue($request->isXmlHttpRequest());
        $this->assertTrue($request->isAjax());
    }
}
