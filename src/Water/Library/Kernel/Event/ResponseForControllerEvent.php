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
 * Class ResponseForControllerEvent
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ResponseForControllerEvent extends ResponseEvent
{
    /**
     * @var mixed
     */
    private $response = null;

    /**
     * {@inheritdoc}
     *
     * @param mixed $response
     */
    public function __construct(HttpKernelInterface $kernel, Request $request, $response)
    {
        $this->response = $response;
        parent::__construct($kernel, $request);
    }
}