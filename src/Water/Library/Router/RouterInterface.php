<?php
/**
 * User: Ivan C. Sanches
 * Date: 22/09/13
 * Time: 21:04
 */
namespace Water\Library\Router;

/**
 * Interface RouterInterface
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
interface RouterInterface
{
    /**
     * Constructor.
     *
     * @param RouteCollection $routes
     * @param array           $options
     */
    public function __construct(RouteCollection $routes, array $options = array());

    /**
     * @see \Water\Library\Router\Matcher\MatcherInterface::match($path)
     */
    public function match($path);

    /**
     * @see \Water\Library\Router\Generator\GeneratorInterface::generate($name)
     */
    public function generate($name);
}