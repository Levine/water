<?php
/**
 * User: Ivan C. Sanches
 * Date: 03/10/13
 * Time: 15:15
 */
namespace Water\Module\FrameworkModule\Router;

use Water\Library\DependencyInjection\ContainerInterface;
use Water\Library\Router\Route;
use Water\Library\Router\RouteCollection;
use Water\Library\Router\Router as BasicRouter;

/**
 * Class Router
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class Router extends BasicRouter
{
    /**
     * @var ContainerInterface
     */
    private $container = null;

    /**
     * Constructor.
     *
     * @param ContainerInterface $container
     * @param RouteCollection    $routes
     * @param array              $options
     */
    public function __construct(ContainerInterface $container, RouteCollection $routes = null, array $options = array())
    {
        $this->container = $container;
        parent::__construct($routes, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function getRoutes()
    {
        if ($this->routes === null) {
            $appConfig = $this->container->getParameter('application_config');
            // TODO - validate routes resource.
            // FIXME - review
            $routes = new RouteCollection();
            if (isset($appConfig['router']['routes'])) {
                foreach ($appConfig['router']['routes'] as $name => $route) {
                    $routes->add($name, new Route($route['path'], $route['resource']));
                }
            }

            $this->routes = $routes;
        }
        return $this->routes;
    }
}