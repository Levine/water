<?php
/**
 * User: Ivan C. Sanches
 * Date: 27/08/13
 * Time: 15:56
 */
namespace Water\Library\Router;

/**
 * Class Route
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class Route
{
    /**
     * @var string
     */
    private $path = '';

    /**
     * @var array
     */
    private $resource = array();

    /**
     * Constructor.
     *
     * @param string $path
     * @param array  $resource
     */
    public function __construct($path, array $resource)
    {
        $this->path     = $path;
        $this->resource = $resource;
    }

    // @codeCoverageIgnoreStart
    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return array
     */
    public function getResource()
    {
        return $this->resource;
    }
    // @codeCoverageIgnoreEnd
}
