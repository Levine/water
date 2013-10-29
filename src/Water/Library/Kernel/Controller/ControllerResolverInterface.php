<?php
/**
 * User: Ivan C. Sanches
 * Date: 22/09/13
 * Time: 18:43
 */
namespace Water\Library\Kernel\Controller;

use Water\Library\Http\Request;

/**
 * Interface ControllerResolverInterface
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
interface ControllerResolverInterface
{
    public function getController(Request $request);

    public function getArguments(Request $request);
}