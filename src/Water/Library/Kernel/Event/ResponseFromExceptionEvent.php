<?php
/**
 * User: Ivan C. Sanches
 * Date: 24/09/13
 * Time: 16:02
 */
namespace Water\Library\Kernel\Event;

use Water\Library\Http\Request;
use Water\Library\Kernel\HttpKernelInterface;

/**
 * Class ResponseFromExceptionEvent
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ResponseFromExceptionEvent extends ResponseEvent
{
    /**
     * @var \Exception
     */
    protected $exception = null;

    /**
     * @param HttpKernelInterface $kernel
     * @param Request             $request
     * @param \Exception          $exception
     */
    public function __construct(HttpKernelInterface $kernel, Request $request, \Exception $exception)
    {
        parent::__construct($kernel, $request);
        $this->exception = $exception;
    }

    // @codeCoverageIgnoreStart
    /**
     * @return \Exception
     */
    public function getException()
    {
        return $this->exception;
    }
    // @codeCoverageIgnoreEnd
}