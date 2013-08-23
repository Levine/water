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

        $header = array();
        foreach ($this as $key => $value) {
            if (preg_match('/^HTTP_.*$/', $key)) {
                $header[substr($key, 5)] = $value;
            } elseif (
                $key == 'CONTENT_LENGTH'
                || $key == 'CONTENT_MD5'
                || $key == 'CONTENT_TYPE'
            ) {
                $header[$key] = $value;
            }
        }

        return $this->header = $header;
    }
}
