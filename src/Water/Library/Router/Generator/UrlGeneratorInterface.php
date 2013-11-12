<?php
/**
 * User: Ivan C. Sanches
 * Date: 09/09/13
 * Time: 14:51
 */
namespace Water\Library\Router\Generator;

use Water\Library\Router\RouteCollection;

/**
 * Interface UrlGeneratorInterface
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
interface UrlGeneratorInterface
{
    /**
     * Constructor.
     *
     * @param RouteCollection $routes
     */
    public function __construct(RouteCollection $routes);

    /**
     * Return the URL specified by name. Otherwise, return ''.
     *
     * @param string $name
     * @return string
     */
    public function generate($name);
}