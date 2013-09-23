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
     */
    const REQUEST = 'kernel.request';

    /**
     * Generate view.
     */
    const VIEW = 'kernel.view';

    /**
     * Handle exception.
     */
    const EXCEPTION = 'kernel.exception';
}