<?php
/**
 * User: Ivan C. Sanches
 * Date: 28/08/13
 * Time: 08:59
 */
namespace Water\Library\Router\Matcher;

/**
 * Interface UrlMatcherInterface
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
interface UrlMatcherInterface
{
    /**
     * Match the resources by path.
     *
     * @param string $path
     * @return array|bool
     */
    public function match($path);
}
