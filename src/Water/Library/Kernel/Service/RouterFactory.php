<?php
/**
 * User: Ivan C. Sanches
 * Date: 17/09/13
 * Time: 08:50
 */
namespace Water\Library\Kernel\Service;

use Water\Library\Kernel\Exception\RouteNotFoundException;
use Water\Library\Router\Route;
use Water\Library\Router\RouteCollection;
use Water\Library\Router\Router;
use Water\Library\ServiceManager\FactoryInterface;
use Water\Library\ServiceManager\ServiceLocatorInterface;

/**
 * Class RouterFactory
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class RouterFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public static function create(ServiceLocatorInterface $sm = null)
    {
        $appConfig = $sm->get('appConfig');
        $routesConfig = isset($appConfig['router']['routes'])
                      ? $appConfig['router']['routes']
                      : array();

        if (empty($routesConfig)) {
            return null;
        }

        $routes = new RouteCollection();
        foreach ($routesConfig as $name => $route) {
            if (isset($route['path']) && isset($route['resource'])) {
                $routes->add($name, new Route($route['path'], $route['resource']));
            }
        }

        $router  = new Router($routes);
        $request = $sm->get('request');

        $resource = $router->match($request->getPath());

        if ($resource) {
            $request->getResource()->fromArray($resource);
            return $router;
        }

        throw new RouteNotFoundException();
    }
}