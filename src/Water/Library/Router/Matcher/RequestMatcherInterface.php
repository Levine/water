<?php
/**
 * User: Ivan C. Sanches
 * Date: 12/11/13
 * Time: 16:24
 */
namespace Water\Library\Router\Matcher;

use Water\Library\Http\Request;

/**
 * Interface RequestMatcherInterface
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
interface RequestMatcherInterface
{
    /**
     * Match a route from Request.
     *
     * @param Request $request
     * @return array|bool
     */
    public function matchFromRequest(Request $request);
} 