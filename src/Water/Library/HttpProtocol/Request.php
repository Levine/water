<?php
/**
 * User: Ivan C. Sanches
 * Date: 21/08/13
 * Time: 22:41
 */
namespace Water\Library\HttpProtocol;

use Water\Library\HttpProtocol\Bag\CookieBag;
use Water\Library\HttpProtocol\Bag\FileBag;
use Water\Library\HttpProtocol\Bag\HeaderBag;
use Water\Library\HttpProtocol\Bag\ParameterBag;
use Water\Library\HttpProtocol\Bag\ServerBag;

/**
 * Class Request
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class Request
{
    /**
     * @var ServerBag
     */
    private $server = null;

    /**
     * @var null|HeaderBag
     */
    private $headers = null;

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
    private $postData = null;

    /**
     * @var string
     */
    private $content = '';

    /**
     * Constructor.
     *
     * @param array  $queryData
     * @param array  $postData
     * @param array  $cookie
     * @param array  $files
     * @param array  $server
     * @param string $content
     */
    public function __construct(array $queryData, array $postData, array $cookie, array $files, array $server, $content = '')
    {
        $this->queryData = new ParameterBag($queryData);
        $this->postData  = new ParameterBag($postData);
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
        return new static($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER, '');
    }

    /**
     * Return a Request create from parameters.
     *
     * @param string $url
     * @param string $method
     * @param array  $request
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

        return new static($query, $post, $cookie, $files, $server, $content);
    }

    /**
     * Return the URL host.
     *
     * @return string
     */
    public function getHost()
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
                    $this->cookie->get(
                        $index,
                        $this->files->get(
                            $index,
                            $default
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
     * TRUE if the method is a Request Method, otherwise FALSE.
     *
     * @param string $method
     * @return bool
     */
    public function isMethod($method)
    {
        if ($this->server->get('REQUEST_METHOD') == strtoupper($method)) {
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
    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return \Water\Library\HttpProtocol\Bag\CookieBag
     */
    public function getCookie()
    {
        return $this->cookie;
    }

    /**
     * @return \Water\Library\HttpProtocol\Bag\FileBag
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @return \Water\Library\HttpProtocol\Bag\HeaderBag
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return \Water\Library\HttpProtocol\Bag\ParameterBag
     */
    public function getPostData()
    {
        return $this->postData;
    }

    /**
     * @return \Water\Library\HttpProtocol\Bag\ParameterBag
     */
    public function getQueryData()
    {
        return $this->queryData;
    }

    /**
     * @return \Water\Library\HttpProtocol\Bag\ServerBag
     */
    public function getServer()
    {
        return $this->server;
    }
    // @codeCoverageIgnoreEnd
}
