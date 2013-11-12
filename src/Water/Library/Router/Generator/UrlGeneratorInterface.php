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
     * Return the URL specified by name. Otherwise, return ''.
     *
     * @param string $name
     * @return string
     */
    public function generate($name);
}