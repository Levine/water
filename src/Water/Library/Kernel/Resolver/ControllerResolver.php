<?php
/**
 * User: Ivan C. Sanches
 * Date: 17/09/13
 * Time: 08:43
 */
namespace Water\Library\Kernel\Resolver;

use Water\Library\Http\Request;
use Water\Library\Kernel\Exception\InvalidArgumentException;

/**
 * Class ControllerResolver
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ControllerResolver implements ControllerResolverInterface
{
    public function getController(Request $request)
    {
        if ($request->getResource()->has('_controller')) {
            return false;
        }

        $controller = $request->getResource()->get('_controller');

        if (is_array($controller)
            || (is_object($controller) && method_exists($controller, '__invoke')) // Invokable class
            || (is_string($controller) && function_exists($controller)) // User function
            || is_callable($controller) // Closure
        ) {
            return $controller;
        }

        if (is_string($controller) && method_exists($controller, '__invoke')) {
            return new $controller;
        }

        if (false === $pos = strpos($controller, '::')) {
            throw new InvalidArgumentException();
        }

        $class  = strtok($controller, '::');
        $method = strtok('::');

        if (!class_exists($class, true) || !is_callable($controller = array(new $class(), $method))) {
            throw new InvalidArgumentException();
        }

        return $controller;
    }

    public function getArguments(Request $request)
    {
        return $request->getResource()->get('_args', array());
    }
}