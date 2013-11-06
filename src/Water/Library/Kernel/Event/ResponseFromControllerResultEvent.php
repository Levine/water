<?php
/**
 * User: Ivan C. Sanches
 * Date: 22/09/13
 * Time: 22:34
 */
namespace Water\Library\Kernel\Event;

use Water\Library\Kernel\HttpKernelInterface;
use Water\Library\Http\Request;

/**
 * Class ResponseFromControllerResultEvent
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ResponseFromControllerResultEvent extends ResponseEvent
{
    /**
     * @var mixed
     */
    protected $controllerResult = null;

    /**
     * {@inheritdoc}
     *
     * @param mixed $controllerResult
     */
    public function __construct(HttpKernelInterface $kernel, Request $request, $controllerResult)
    {
        parent::__construct($kernel, $request);
        $this->controllerResult = $controllerResult;
    }

    /**
     * @return mixed
     */
    public function getControllerResult()
    {
        return $this->controllerResult;
    }
}