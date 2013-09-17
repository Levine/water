<?php
/**
 * User: Ivan C. Sanches
 * Date: 17/09/13
 * Time: 08:43
 */
namespace Water\Library\Kernel\Resolver;

use Water\Library\Http\Request;
use Water\Library\Kernel\Exception\ControllerNotFoundException;

/**
 * Class ControllerResolver
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ControllerResolver
{
    public function getController(Request $request)
    {
        $controller = $request->getResource()->get('_controller');
        if (false !== $pos = strpos($controller, '::')) {
            $class  = substr($controller, 0, $pos);
            $method = substr($controller, $pos + 2);

            if (class_exists($class, true)) {
                return array(new $class(), $method);
            }
        }

        throw new ControllerNotFoundException(
            'Controller not found, the controller has to be like that "<ControllerName>::<methodName>".'
        );
    }
}