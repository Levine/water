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
     * @param array  $file
     * @param array  $server
     * @param string $content
     */
    public function __construct(array $queryData, array $postData, array $cookie, array $file, array $server, $content = '')
    {
        $this->queryData = new ParameterBag($queryData);
        $this->postData  = new ParameterBag($postData);
        $this->cookie    = new CookieBag($cookie);
        $this->files     = new FileBag($file);
        $this->server    = new ServerBag($server);
        $this->headers   = new HeaderBag($this->server->getHeaders());

        $this->content   = '';
    }

    /**
     * Returns a Request created from de Globals variables.
     *
     * @return Request
     */
    public static function createFromGlobals()
    {
        return new static($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER, '');
    }

    /**
     * Returns the value of a specified index, if the index not exists return a default value.
     *
     * @param mixed $index
     * @param mixed $default
     * @return mixed
     */
    public function get($index, $default = ParameterBag::DEFAULT_VALUE)
    {
        return $this->queryData->get(
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
