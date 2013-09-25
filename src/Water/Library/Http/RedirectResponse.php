<?php
/**
 * User: Ivan C. Sanches
 * Date: 25/09/13
 * Time: 15:36
 */
namespace Water\Library\Http;

use Water\Library\Http\Bag\HeaderBag;
use Water\Library\Http\Exception\InvalidArgumentException;

/**
 * Class RedirectResponse
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class RedirectResponse extends Response
{
    /**
     * @var string
     */
    protected $targetUrl = '';

    /**
     * Constructor.
     *
     * @param string $url
     * @param int    $statusCode
     * @param array  $headers
     */
    public function __construct($url, $statusCode = 302, array $headers = array())
    {
        $this->headers    = new HeaderBag($headers);
        $this->statusCode = $statusCode;
        $this->setTargetUrl($url);
    }

    /**
     * @param string $url
     * @param int    $statusCode
     * @param array  $headers
     * @return RedirectResponse
     */
    public static function create($url, $statusCode = 302, array $headers = array())
    {
        return new static($url, $statusCode, $headers);
    }

    /**
     * @param string $url
     * @return RedirectResponse
     *
     * @throws InvalidArgumentException
     */
    public function setTargetUrl($url)
    {
        if (empty($url)) {
            throw new InvalidArgumentException("Url parameters can't be empty.");
        }

        $htmlUrl = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
        $this->content = <<<EOT
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="refresh" content="1;url=$htmlUrl" />

<title>Redirecting to $htmlUrl</title>
</head>
<body>
Redirecting to <a href="$htmlUrl">$htmlUrl</a>.
</body>
</html>
EOT;
        $this->headers->set('Location', $url);

        return $this;
    }
}