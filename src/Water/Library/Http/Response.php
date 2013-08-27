<?php
/**
 * User: Ivan C. Sanches
 * Date: 27/08/13
 * Time: 14:48
 */
namespace Water\Library\Http;
use Water\Library\Http\Bag\HeaderBag;

/**
 * Class Response
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class Response
{
    private static $recommendedReasonPhrases = array(
        // INFORMATIONAL CODES
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        // SUCCESS CODES
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-status',
        208 => 'Already Reported',
        // REDIRECTION CODES
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Switch Proxy', // Deprecated
        307 => 'Temporary Redirect',
        // CLIENT ERROR
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Time-out',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Large',
        415 => 'Unsupported Media Type',
        416 => 'Requested range not satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        425 => 'Unordered Collection',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        // SERVER ERROR
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Time-out',
        505 => 'HTTP Version not supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        511 => 'Network Authentication Required',
    );

    /**
     * @var array
     */
    private $headers = array();

    /**
     * @var string
     */
    private $version = '';

    /**
     * @var int
     */
    private $statusCode = 0;

    /**
     * @var string
     */
    private $statusPhrase = '';

    /**
     * @var string
     */
    private $content = '';

    /**
     * Constructor.
     *
     * @param mixed  $content
     * @param int    $statusCode
     * @param array  $headers
     */
    public function __construct($content, $statusCode = 200, array $headers = array())
    {
        $this->headers      = new HeaderBag($headers);
        $this->version      = '1.1';
        $this->statusCode   = $statusCode;
        $this->statusPhrase = (isset(self::$recommendedReasonPhrases[$this->statusCode]))
                            ? self::$recommendedReasonPhrases[$this->statusCode]
                            : '';
        $this->content      = $content;
    }

    /**
     * Return a new instance of Response.
     *
     * @param mixed $content
     * @param int   $statusCode
     * @param array $headers
     * @return Response
     */
    public static function create($content, $statusCode = 200, array $headers = array())
    {
        return new static($content, $statusCode, $headers);
    }

    /**
     * @return Response
     */
    public function sendHeader()
    {
        if (headers_sent()) {
            return $this;
        }

        header(sprintf('HTTP/%s %s %s', $this->version, $this->statusCode, $this->getStatusPhrase()));
        foreach ($this->headers as $key => $value) {
            header(sprintf('%s: %s', $key, $value));
        }
        return $this;
    }

    /**
     * @return Response
     */
    public function sendContent()
    {
        echo $this->content;
        return $this;
    }

    /**
     * Send the response.
     *
     * @return Response
     */
    public function send()
    {
        $this->sendHeader()
             ->sendContent();

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $response = sprintf("HTTP/%s %s %s\r\n", $this->version, $this->statusCode, $this->getStatusPhrase());
        $response .= (string) $this->headers;
        $response .= "\r\n";
        $response .= $this->getContent();
        return $response;
    }

    // @codeCoverageIgnoreStart
    /**
     * @param string $content
     * @return Response
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $index
     * @param mixed  $value
     * @return Response
     */
    public function addHeader($index, $value)
    {
        $this->headers->set($index, $value);
        return $this;
    }

    /**
     * @param array $headers
     * @return Response
     */
    public function setHeaders(array $headers)
    {
        $this->headers->fromArray($headers);
        return $this;
    }

    /**
     * @return HeaderBag
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param int $statusCode
     * @return Response
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param string $statusPhrase
     * @return Response
     */
    public function setStatusPhrase($statusPhrase)
    {
        $this->statusPhrase = $statusPhrase;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatusPhrase()
    {
        return $this->statusPhrase;
    }

    /**
     * @param string $version
     * @return Response
     */
    public function setVersion($version)
    {
        $this->version = $version;
        return $this;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }
    // @codeCoverageIgnoreEnd
}
