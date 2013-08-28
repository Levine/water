<?php
/**
 * User: Ivan C. Sanches
 * Date: 27/08/13
 * Time: 15:56
 */
namespace Water\Library\Router;

use \ArrayIterator;
use \Countable;
use \IteratorAggregate;

/**
 * Class RouteCollection
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class RouteCollection implements IteratorAggregate, Countable
{
    /**
     * @var array
     */
    private $routes = array();

    /**
     * Add a route in the collection.
     *
     * @param string $name
     * @param Route  $route
     * @return RouteCollection
     */
    public function add($name, Route $route)
    {
        unset($this->routes[$name]);
        $this->routes[$name] = $route;
        return $this;
    }

    /**
     * Remove the route specified by name.
     *
     * @param $name
     * @return RouteCollection
     */
    public function remove($name)
    {
        unset($this->routes[$name]);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->routes);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new ArrayIterator($this->routes);
    }

    // @codeCoverageIgnoreStart
    /**
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }
    // @codeCoverageIgnoreEnd
}
