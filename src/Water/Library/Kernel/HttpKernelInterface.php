<?php
/**
 * User: Ivan C. Sanches
 * Date: 17/09/13
 * Time: 08:11
 */
namespace Water\Library\Kernel;

use Water\Library\EventDispatcher\EventDispatcherInterface;
use Water\Library\Http\Request;
use Water\Library\Http\Response;
use Water\Library\Kernel\Resolver\ControllerResolverInterface;

/**
 * Interface HttpKernelInterface
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
interface HttpKernelInterface
{
    /**
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request);

    /**
     * @return EventDispatcherInterface
     */
    public function getDispatcher();

    /**
     * @return ControllerResolverInterface
     */
    public function getControllerResolver();
}