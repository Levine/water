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
        if (!$request->getResource()->has('_controller')) {
            return false;
        }

        $controller = $request->getResource()->get('_controller');

        if (
            is_array($controller)
            || (is_object($controller) && method_exists($controller, '__invoke'))
            || (is_string($controller) && function_exists($controller))
            || ($controller instanceof \Closure)
        ) {
            return $controller;
        }

        if (is_string($controller) && method_exists($controller, '__invoke')) {
            return new $controller;
        }

        if (false === $pos = strpos($controller, '::')) {
            throw new InvalidArgumentException(sprintf(
                'Controller has to be a "array", "invokable class", "function" or "<ControllerName>::<methodName>" ("%s" given).',
                $controller
            ));
        }

        $class  = strtok($controller, '::');
        $method = strtok('::');

        if (!class_exists($class, true) || !is_callable($controller = array(new $class(), $method))) {
            throw new InvalidArgumentException("Controller isn't a valid class or isn't callable.");
        }

        return $controller;
    }

    public function getArguments(Request $request)
    {
        if (!is_array($args = $request->getResource()->get('_args', array()))) {
            $args = array($args);
        }
        return $args;
    }
}