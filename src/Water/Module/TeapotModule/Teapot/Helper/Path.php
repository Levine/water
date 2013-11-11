<?php
/**
 * User: Ivan C. Sanches
 * Date: 11/11/13
 * Time: 13:48
 */
namespace Water\Module\TeapotModule\Teapot\Helper;

/**
 * Class Path
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class Path
{
    /**
     * @var string
     */
    private $schemeHost = '';

    /**
     * @param string $schemeHost
     * @return Path
     */
    public function setSchemeHost($schemeHost)
    {
        $this->schemeHost = $schemeHost;
        return $this;
    }

    public function __invoke($url = '')
    {
        return $this->schemeHost . $url;
    }
}