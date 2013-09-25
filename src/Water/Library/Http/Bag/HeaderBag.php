<?php
/**
 * User: Ivan C. Sanches
 * Date: 22/08/13
 * Time: 22:27
 */
namespace Water\Library\Http\Bag;

/**
 * Class HeaderBag
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class HeaderBag extends ParameterBag
{
    /**
     * {@inheritdoc}
     */
    public function __construct(array $input = array())
    {
        $input = $this->normalizeHeadersName($input);
        parent::__construct($input);
    }

    /**
     * Return normalized header name.
     *
     * @param string $headerName
     * @return string
     */
    private function normalizeHeaderName($headerName)
    {
        $headerName = str_replace('_', ' ', str_replace('-', ' ', strtolower($headerName)));
        $headerName = str_replace(' ', '-', ucwords($headerName));
        return $headerName;
    }

    /**
     * Returns normalized headers name.
     *
     * @param array $input
     * @return array
     */
    private function normalizeHeadersName(array $input)
    {
        $headers = array();
        foreach ($input as $key => $value) {
            $headerName = $this->normalizeHeaderName($key);
            $headers[$headerName] = $value;
        }
        return $headers;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($index, $newval)
    {
        $this->set($index, $newval);
    }

    /**
     * {@inheritdoc}
     */
    public function set($index, $value)
    {
        $headerName = $this->normalizeHeaderName($index);
        return parent::set($headerName, $value);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $string = '';
        foreach ($this as $key => $value) {
            $string .= sprintf("%s: %s\r\n", $key, $value);
        }
        return $string;
    }
}
