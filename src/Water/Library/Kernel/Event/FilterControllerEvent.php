<?php
/**
 * User: Ivan C. Sanches 
 * Date: 29/10/13
 * Time: 17:58
 */
namespace Water\Library\Kernel\Event;

use Water\Library\Http\Request;
use Water\Library\Kernel\HttpKernelInterface;

/**
 * Class FilterControllerEvent
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class FilterControllerEvent extends KernelEvent
{
    /**
     * @var mixed
     */
    protected $controller;

    /**
     * {@inheritdoc}
     *
     * @param mixed $controller
     */
    public function __construct(HttpKernelInterface $kernel, Request $request, $controller)
    {
        parent::__construct($kernel, $request);
        $this->controller = $controller;
    }

    // @codeCoverageIgnoreStart
    /**
     * @param mixed $controller
     * @return FilterControllerEvent
     */
    public function setController($controller)
    {
        $this->controller = $controller;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }
    // @codeCoverageIgnoreEnd
} 