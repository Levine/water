<?php
/**
 * User: Ivan C. Sanches
 * Date: 28/08/13
 * Time: 08:57
 */
namespace Water\Library\Router\Matcher;

use Water\Library\Http\Request;
use Water\Library\Router\Context\RequestContext;
use Water\Library\Router\RouteCollection;

/**
 * Class UrlMatcher
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class UrlMatcher implements UrlMatcherInterface, RequestMatcherInterface
{
    /**
     * @var RouteCollection
     */
    private $routes = null;

    /**
     * @var RequestContext
     */
    private $context = null;

    /**
     * Constructor.
     *
     * @param RouteCollection $routes
     * @param RequestContext  $context
     */
    public function __construct(RouteCollection $routes, RequestContext $context)
    {
        $this->routes  = $routes;
        $this->context = $context;
    }

    /**
     * {@inheritdoc}
     */
    public function match($path)
    {
        foreach ($this->routes as $name => $route) {
            if ($route->getPath() == $path) {
                return $route->getResource();
            }
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function matchFromRequest(Request $request)
    {

    }
}
