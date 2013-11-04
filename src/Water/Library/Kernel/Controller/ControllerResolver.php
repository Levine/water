<?php
/**
 * User: Ivan C. Sanches
 * Date: 17/09/13
 * Time: 08:43
 */
namespace Water\Library\Kernel\Controller;

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

        $controller = $this->createController($controller);

        return $controller;
    }

    /**
     * Method to create the controller instance.
     *
     * @param string $controller
     * @return object
     *
     * @throws InvalidArgumentException
     */
    protected function createController($controller)
    {
        if (substr_count($controller, '::') != 1) {
            throw new InvalidArgumentException(sprintf(
                'Controller has to be a "array", "invokable class", "function" '
                . 'or "<ControllerName>::<methodName>" ("%s" given).',
                $controller
            ));
        }

        $class  = strtok($controller, '::');
        $method = strtok('::');

        if (!class_exists($class, true)
            || !is_callable($controller = array(new $class(), $method))
        ) {
            throw new InvalidArgumentException("Controller isn't a valid class or isn't callable.");
        }

        return $controller;
    }

    public function getArguments(Request $request)
    {
        $args = array();
        if ($request->getResource()->has('_args')) {
            $args = $request->getResource()->get('_args');
            if (!is_array($args)) {
                $args = array($args);
            }
        }
        return $args;
    }
}