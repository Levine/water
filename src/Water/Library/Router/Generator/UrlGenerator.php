<?php
/**
 * User: Ivan C. Sanches
 * Date: 09/09/13
 * Time: 15:23
 */
namespace Water\Library\Router\Generator;

use Water\Library\Router\RouteCollection;

/**
 * Class UrlGenerator
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class UrlGenerator implements GeneratorInterface
{
    /**
     * @var RouteCollection
     */
    private $routes = null;

    /**
     * {@inheritdoc}
     */
    public function __construct(RouteCollection $routes)
    {
        $this->routes  = $routes;
    }

    /**
     * {@inheritdoc}
     */
    public function generate($name)
    {
        if (null !== $route = $this->routes->get($name)) {
            return $route->getPath();
        }
        return '';
    }
}