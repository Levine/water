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
use Water\Library\Kernel\Controller\ControllerResolverInterface;

/**
 * Interface HttpKernelInterface
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
interface HttpKernelInterface
{
    /**
     * @param Request $request
     * @param bool    $catch
     * @return Response
     *
     * @throws \Exception
     */
    public function handle(Request $request, $catch = true);

    /**
     * @return EventDispatcherInterface
     */
    public function getDispatcher();

    /**
     * @return ControllerResolverInterface
     */
    public function getResolver();
}