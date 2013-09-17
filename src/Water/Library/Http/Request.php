<?php
/**
 * User: Ivan C. Sanches
 * Date: 21/08/13
 * Time: 22:41
 */
namespace Water\Library\Http;

use Water\Library\Http\Bag\CookieBag;
use Water\Library\Http\Bag\FileBag;
use Water\Library\Http\Bag\HeaderBag;
use Water\Library\Http\Bag\ParameterBag;
use Water\Library\Http\Bag\ServerBag;

/**
 * Class Request
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class Request
{
    /**
     * @var bool
     */
    private static $allowOverrideMethod = false;

    /**
     * @var ServerBag
     */
    private $server = null;

    /**
     * @var null|HeaderBag
     */
    private $headers = null;

    /**
     * @var string
     */
    private $method = '';

    /**
     * @var FileBag
     */
    private $files = null;

    /**
     * @var CookieBag
     */
    private $cookie = null;

    /**
     * @var ParameterBag
     */
    private $queryData = null;

    /**
     * @var ParameterBag
     */
    private $resource = null;

    /**
     * @var ParameterBag
     */
    private $postData = null;

    /**
     * @var string
     */
    private $content = null;

    /**
     * Constructor.
     *
     * @param array  $queryData
     * @param array  $postData
     * @param array  $resource
     * @param array  $cookie
     * @param array  $files
     * @param array  $server
     * @param string $content
     */
    public function __construct(array $queryData, array $postData, array $resource, array $cookie, array $files, array $server, $content = '')
    {
        $this->queryData = new ParameterBag($queryData);
        $this->postData  = new ParameterBag($postData);
        $this->resource  = new ParameterBag($resource);
        $this->cookie    = new CookieBag($cookie);
        $this->files     = new FileBag($files);
        $this->server    = new ServerBag($server);
        $this->headers   = new HeaderBag($this->server->getHeaders());

        $this->content   = '';
    }

    /**
     * Return a Request created from de Globals variables.
     *
     * @return Request
     */
    public static function createFromGlobals()
    {
        return new static($_GET, $_POST, array(), $_COOKIE, $_FILES, $_SERVER, '');
    }

    /**
     * Return a Request create from parameters.
     *
     * @param string $url
     * @param string $method
     * @param array  $request
     * @param array  $resource
     * @param array  $cookie
     * @param array  $files
     * @param array  $server
     * @param string $content
     * @return Request
     */
    public static function create(
        $url = '/',
        $method = 'GET',
        array $request = array(),
        array $resource = array(),
        array $cookie = array(),
        array $files = array(),
        array $server = array(),
        $content = ''
    ) {
        $_server = array(
            'HTTP_HOST'             => 'localhost',
            'HTTP_USER_AGENT'       => 'Water/1.0',
            'HTTP_ACCEPT'           => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'HTTP_ACCEPT_LANGUAGE'  => 'pt-BR,pt;q=0.8,en-US;q=0.6,en;q=0.4',
            'HTTP_ACCEPT_CHARSET'   => 'utf-8,ISO-8859-1;q=0.7,*;q=0.7',
            'SERVER_NAME'           => 'localhost',
            'SERVER_PORT'           => 80,
            'REMOTE_ADDR'           => '127.0.0.1',
            'SCRIPT_NAME'           => '',
            'SCRIPT_FILENAME'       => '',
            'SERVER_PROTOCOL'       => 'HTTP/1.1',
            'REQUEST_TIME'          => time(),
        );

        $server = array_merge($_server, $server);

        $components = parse_url($url);

        if (isset($components['scheme']) && $components['scheme'] == 'https') {
            $server['HTTPS']       = 'on';
            $server['SERVER_PORT'] = 443;
        } else {
            unset($server['HTTPS']);
            $server['SERVER_PORT'] = 80;
        }

        if (isset($components['host'])) {
            $server['HTTP_HOST']   = $components['host'];
            $server['SERVER_NAME'] = $components['host'];
        }

        if (isset($components['port'])) {
            $server['SERVER_PORT'] = $components['port'];
            $server['HTTP_HOST']   = $server['HTTP_HOST'].':'.$components['port'];
        }

        if (isset($components['user'])) {
            $server['PHP_AUTH_USER'] = $components['user'];
        }

        if (isset($components['pass'])) {
            $server['PHP_AUTH_PW'] = $components['pass'];
        }

        if (!isset($components['path'])) {
            $components['path'] = '/';
        }

        $server['REQUEST_METHOD'] = $method = strtoupper($method);
        switch ($method) {
            case 'POST':
            case 'PUT':
            case 'DELETE':
                $post  = $request;
                $query = array();
                if (!isset($server['CONTENT_TYPE'])) {
                    $server['CONTENT_TYPE'] = 'application/x-www-form-urlencoded';
                }
                break;
            default:
                $post  = array();
                $query = $request;
                break;
        }

        if (isset($components['query'])) {
            parse_str(html_entity_decode($components['query']), $qs);
            $query = array_replace($qs, $query);
        }
        $queryString = http_build_query($query, '', '&');

        $server['REQUEST_URI']  = $components['path'].('' !== $queryString ? '?'.$queryString : '');
        $server['QUERY_STRING'] = $queryString;

        return new static($query, $post, $resource, $cookie, $files, $server, $content);
    }

    /**
     * Override the global variables.
     */
    public function overrideGlobals()
    {
        $_GET    = $this->queryData->toArray();
        $_POST   = $this->postData->toArray();
        $_COOKIE = $this->cookie->toArray();
        $_FILES  = $this->files->toArray();
        $_SERVER = $this->server->toArray();
    }

    /**
     * Return the URL scheme.
     *
     * @return string
     */
    public function getScheme()
    {
        return ($this->isSecure()) ? 'https' : 'http';
    }

    /**
     * Return the URL host.
     *
     * @return string
     */
    public function getHost()
    {
        return $this->server->get('SERVER_NAME', '');
    }

    /**
     * Return the URL port.
     *
     * @return integer
     */
    public function getPort()
    {
        return $this->server->get('SERVER_PORT', 0);
    }

    /**
     * Return the URL user.
     *
     * @return string
     */
    public function getUser()
    {
        return $this->server->get('PHP_AUTH_USER', '');
    }

    /**
     * Return the URL password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->server->get('PHP_AUTH_PW', '');
    }

    /**
     * Return the URL path.
     *
     * @return string
     */
    public function getPath()
    {
        $requestUri = $this->server->get('REQUEST_URI', '/');
        if ($pos = strpos($requestUri, '?')) {
            $requestUri = substr($requestUri, 0, $pos);
        }
        return $requestUri;
    }

    /**
     * Return the URL query.
     *
     * @return string
     */
    public function getQuery()
    {
        return $this->server->get('QUERY_STRING', '');
    }

    /**
     * Return the URL host.
     *
     * @return string
     */
    public function getSchemeHost()
    {
        $host = ($this->isSecure()) ? 'https://' : 'http://';
        if ($this->server->has('PHP_AUTH_USER')) {
            $host .= $this->server->get('PHP_AUTH_USER');
            $host .= ($this->server->has('PHP_AUTH_PW'))
                   ? ':' . $this->server->get('PHP_AUTH_PW')
                   : '';
            $host .= '@';
        }
        $host .= $this->server->get('HTTP_HOST');
        return $host;
    }

    /**
     * Return the request url.
     *
     * @return string
     */
    public function getUrl()
    {
        $url = $this->getSchemeHost() . $this->getPath();
        if ('' !== $query = $this->getQuery()) {
            $url .= '?' . $query;
        }
        return $url;
    }

    /**
     * Returns the value of a specified index, if the index not exists return a default value.
     *
     * @param mixed $index
     * @param mixed $default
     * @return mixed|null
     */
    public function get($index, $default = ParameterBag::DEFAULT_VALUE)
    {
        return
            $this->queryData->get(
                $index,
                $this->postData->get(
                    $index,
                    $this->resource->get(
                        $index,
                        $this->cookie->get(
                            $index,
                            $this->files->get(
                                $index,
                                $default
                            )
                        )
                    )
                )
            );
    }

    /**
     * TRUE if the Request Protocol is HTTPS, otherwise FALSE
     *
     * @return bool
     */
    public function isSecure()
    {
        if ($this->server->get('HTTPS') !== null) {
            return true;
        }
        return false;
    }

    /**
     * Return the simulated request method.
     *
     * @return string
     */
    public function getMethod()
    {
        if ($this->method !== '') {
            return $this->method;
        }

        $this->method = $this->getRealMethod();
        if ($this->method == 'POST') {
            if (self::$allowOverrideMethod) {
                $this->method = strtoupper($this->postData->get('_method', 'POST'));
            }
        }
        return $this->method;
    }

    /**
     * Return the real request method.
     *
     * @return string|null
     */
    public function getRealMethod()
    {
        return strtoupper($this->server->get('REQUEST_METHOD', 'GET'));
    }

    /**
     * TRUE if the method is a Request Method, otherwise FALSE.
     *
     * @param string $method
     * @return bool
     */
    public function isMethod($method)
    {
        if ($this->getMethod() == strtoupper($method)) {
            return true;
        }
        return false;
    }

    /**
     * TRUE if the Request Method is GET, otherwise FALSE.
     *
     * @return bool
     */
    public function isGet()
    {
        return $this->isMethod('GET');
    }

    /**
     * TRUE if the Request Method is POST, otherwise FALSE.
     *
     * @return bool
     */
    public function isPost()
    {
        return $this->isMethod('POST');
    }

    /**
     * TRUE if the request is a XmlHttpRequest.
     *
     * @return bool
     */
    public function isXmlHttpRequest()
    {
        if ($this->server->get('X-Requested-With') == 'XMLHttpRequest') {
            return true;
        }
        return false;
    }

    /**
     * Alias of isXmlHttpRequest method.
     *
     * @return bool
     */
    public function isAjax()
    {
        return $this->isXmlHttpRequest();
    }

    // @codeCoverageIgnoreStart
    public static function enableOverrideMethod()
    {
        self::$allowOverrideMethod = true;
    }

    public static function unableOverrideMethod()
    {
        self::$allowOverrideMethod = false;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        if ($this->content === null) {
            $this->content = file_get_contents('php://input');
        }
        return $this->content;
    }

    /**
     * @return \Water\Library\Http\Bag\CookieBag
     */
    public function getCookie()
    {
        return $this->cookie;
    }

    /**
     * @return \Water\Library\Http\Bag\FileBag
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @return \Water\Library\Http\Bag\HeaderBag
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return \Water\Library\Http\Bag\ParameterBag
     */
    public function getPostData()
    {
        return $this->postData;
    }

    /**
     * @return \Water\Library\Http\Bag\ParameterBag
     */
    public function getQueryData()
    {
        return $this->queryData;
    }

    /**
     * @return \Water\Library\Http\Bag\ParameterBag
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @return \Water\Library\Http\Bag\ServerBag
     */
    public function getServer()
    {
        return $this->server;
    }
    // @codeCoverageIgnoreEnd
}
