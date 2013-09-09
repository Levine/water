<?php
/**
 * User: Ivan C. Sanches
 * Date: 28/08/13
 * Time: 08:57
 */
namespace Water\Library\Router\Matcher;

use Water\Library\Router\RouteCollection;

/**
 * Class UrlMatcher
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class UrlMatcher implements MatcherInterface
{
    /**
     * @var RouteCollection
     */
    private $routes = null;

    /**
     * Constructor.
     *
     * @param RouteCollection $routes
     */
    public function __construct(RouteCollection $routes)
    {
        $this->routes = $routes;
    }

    /**
     * {@inheritdoc}
     */
    public function match($path)
    {
        foreach ($this->routes as $name => $route) {
            if ($route->getPath() == $path) {
                $return = array();
                $return['name']  = $name;
                $return['route'] = $route;
                return $return;
            }
        }
        return false;
    }
}
