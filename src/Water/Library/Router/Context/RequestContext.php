<?php
/**
 * User: Ivan C. Sanches
 * Date: 09/09/13
 * Time: 15:24
 */
namespace Water\Library\Router\Context;

use Water\Library\Http\Request;

/**
 * Class RequestContext
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class RequestContext
{
    private $scheme = '';
    private $host   = '';
    private $port   = 0;
    private $path   = '';
    private $query  = '';

    private $method = 'GET';

    /**
     * Constructor.
     *
     * @param string $path
     * @param string $method
     * @param string $host
     * @param string $scheme
     * @param int    $port
     */
    public function __construct($path = '/', $method = 'GET', $host = 'localhost', $scheme = 'http', $port = 80)
    {
        $this->scheme = $scheme;
        $this->host   = $host;
        $this->port   = $port;

        if (!$pos = strpos($path, '?')) {
            $this->path = $path;
        } else {
            $this->path  = substr($path, 0, $pos);
            $this->query = substr($path, $pos + 1);
        }
        if ($this->path[0] != '/') {
            $this->path = "/{$this->path}";
        }
        $this->method = $method;
    }

    /**
     * Create a RequestContext from Request.
     *
     * @param Request $request
     * @return RequestContext
     */
    public static function createFromRequest(Request $request)
    {
        return new static(
            $request->getPath(),
            $request->getMethod(),
            $request->getHost(),
            $request->getScheme(),
            $request->getPort()
        );
    }

    /**
     * Define the RequestContext using a Water\Library\Http\Request.
     *
     * @param Request $request
     * @return RequestContext
     */
    public function fromRequest(Request $request)
    {
        $this->scheme = $request->getScheme();
        $this->host   = $request->getHost();
        $this->port   = $request->getPort();
        $this->path   = $request->getPath();
        $this->query  = $request->getQuery();
        $this->method = $request->getMethod();
        return $this;
    }

    // @codeCoverageIgnoreStart
    /**
     * @param string $host
     * @return RequestContext
     */
    public function setHost($host)
    {
        $this->host = $host;
        return $this;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $method
     * @return RequestContext
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $path
     * @return RequestContext
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param int $port
     * @return RequestContext
     */
    public function setPort($port)
    {
        $this->port = $port;
        return $this;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param string $query
     * @return RequestContext
     */
    public function setQuery($query)
    {
        $this->query = $query;
        return $this;
    }

    /**
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param string $scheme
     * @return RequestContext
     */
    public function setScheme($scheme)
    {
        $this->scheme = $scheme;
        return $this;
    }

    /**
     * @return string
     */
    public function getScheme()
    {
        return $this->scheme;
    }
    // @codeCoverageIgnoreEnd
}