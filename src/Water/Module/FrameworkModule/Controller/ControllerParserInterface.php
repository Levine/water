<?php
/**
 * User: Ivan C. Sanches 
 * Date: 29/10/13
 * Time: 09:39
 */
namespace Water\Module\FrameworkModule\Controller;

/**
 * Interface ControllerParserInterface
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
interface ControllerParserInterface
{
    /**
     * Parse a controller name.
     *
     * @param string $controller
     * @return mixed
     */
    public function parse($controller);
} 