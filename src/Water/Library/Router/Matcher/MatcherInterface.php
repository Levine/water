<?php
/**
 * User: Ivan C. Sanches
 * Date: 28/08/13
 * Time: 08:59
 */
namespace Water\Library\Router\Matcher;
use Water\Library\Router\RouteCollection;

/**
 * Interface MatcherInterface
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
interface MatcherInterface
{
    /**
     * Constructor.
     *
     * @param RouteCollection $routes
     */
    public function __construct(RouteCollection $routes);

    /**
     * Match the resources by path.
     *
     * @param string $path
     * @return mixed|bool
     */
    public function match($path);
}
