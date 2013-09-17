<?php
/**
 * User: Ivan C. Sanches
 * Date: 17/09/13
 * Time: 08:43
 */
namespace Water\Library\Kernel\Resolver;

use Water\Library\Http\Request;

/**
 * Class ControllerResolver
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ControllerResolver
{
    public function getController(Request $request)
    {
        return $request->getResource()->get('_controller');
    }
}