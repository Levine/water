<?php
/**
 * User: Ivan C. Sanches
 * Date: 27/08/13
 * Time: 15:56
 */
namespace Water\Library\Router;

/**
 * Class RouteCollection
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class RouteCollection
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
