<?php
/**
 * User: Ivan C. Sanches
 * Date: 28/08/13
 * Time: 08:59
 */
namespace Water\Library\Router\Matcher;

/**
 * Interface MatcherInterface
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
interface MatcherInterface
{
    /**
     * Match the resources by path.
     *
     * @param string $path
     * @return mixed|void
     */
    public function match($path);
}
