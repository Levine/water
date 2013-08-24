<?php
/**
 * User: Ivan C. Sanches
 * Date: 22/08/13
 * Time: 14:23
 */
namespace Water\Library\HttpProtocol\Bag;

/**
 * Class ServerBag
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ServerBag extends ParameterBag
{
    /**
     * @var array
     */
    private $header = array();

    public function getHeaders()
    {
        if (!empty($this->header)) {
            return $this->header;
        }

        $headers = array();
        foreach ($this as $key => $value) {
            if (preg_match('/^HTTP_.*$/', $key)) {
                $headers[substr($key, 5)] = $value;
            } elseif (
                $key == 'CONTENT_LENGTH'
                || $key == 'CONTENT_MD5'
                || $key == 'CONTENT_TYPE'
            ) {
                $headers[$key] = $value;
            }
        }

        /**
         * Symfony2 implementation.
         */
        if ($this->has('PHP_AUTH_USER')) {
            $headers['PHP_AUTH_USER'] = $this->get('PHP_AUTH_USER');
            $headers['PHP_AUTH_PW']   = $this->get('PHP_AUTH_PW','');
        } else {
            $authorizationHeader = null;
            if ($this->has('HTTP_AUTHORIZATION')) {
                $authorizationHeader = $this->get('HTTP_AUTHORIZATION');
            } elseif ($this->has('REDIRECT_HTTP_AUTHORIZATION')) {
                $authorizationHeader = $this->get('REDIRECT_HTTP_AUTHORIZATION');
            }

            if ((null !== $authorizationHeader) && (0 === stripos($authorizationHeader, 'basic'))) {
                $exploded = explode(':', base64_decode(substr($authorizationHeader, 6)));
                if (count($exploded) == 2) {
                    list($headers['PHP_AUTH_USER'], $headers['PHP_AUTH_PW']) = $exploded;
                }
            }
        }

        if (isset($headers['PHP_AUTH_USER'])) {
            $headers['AUTHORIZATION'] = 'Basic '.base64_encode($headers['PHP_AUTH_USER'].':'.$headers['PHP_AUTH_PW']);
        }

        return $this->header = $headers;
    }
}
