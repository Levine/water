<?php
/**
 * User: Ivan C. Sanches
 * Date: 22/09/13
 * Time: 20:45
 */
namespace Water\Library\Kernel;

/**
 * Class KernelEvents
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class KernelEvents
{
    /**
     * Handle the request.
     * Event passed: \Water\Library\Kernel\Event\ResponseEvent
     */
    const REQUEST = 'kernel.request';

    /**
     * Filter controller.
     * Event passed: \Water\Library\Kernel\Event\FilterControllerEvent
     */
    const CONTROLLER = 'kernel.controller';

    /**
     * Generate view.
     * Event passed: \Water\Library\Kernel\Event\ResponseFromControllerResultEvent
     */
    const VIEW = 'kernel.view';

    /**
     * Filter response.
     * Event passed: \Water\Library\Kernel\Event\FilterResponseEvent
     */
    const RESPONSE = 'kernel.response';

    /**
     * Handle exception.
     * Event passed: \Water\Library\Kernel\Event\ResponseFromExceptionEvent
     */
    const EXCEPTION = 'kernel.exception';
}