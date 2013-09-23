<?php
/**
 * User: Ivan C. Sanches
 * Date: 22/09/13
 * Time: 21:32
 */
namespace Water\Library\Kernel\Event;

use Water\Library\EventDispatcher\Event;
use Water\Library\Http\Request;
use Water\Library\Kernel\HttpKernelInterface;

/**
 * Class KernelEvent
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class KernelEvent extends Event
{
    /**
     * @var HttpKernelInterface
     */
    private $kernel = null;

    /**
     * @var Request
     */
    private $request = null;

    /**
     * Constructor.
     *
     * @param HttpKernelInterface $kernel
     * @param Request             $request
     */
    public function __construct(HttpKernelInterface $kernel, Request $request)
    {
        $this->kernel  = $kernel;
        $this->request = $request;
    }

    // @codeCoverageIgnoreStart
    /**
     * @return \Water\Library\Kernel\HttpKernelInterface
     */
    public function getKernel()
    {
        return $this->kernel;
    }

    /**
     * @return \Water\Library\Http\Request
     */
    public function getRequest()
    {
        return $this->request;
    }
    // @codeCoverageIgnoreEnd
}