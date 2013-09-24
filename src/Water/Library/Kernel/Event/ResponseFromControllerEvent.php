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
 * Class ResponseFromControllerEvent
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ResponseFromControllerEvent extends ResponseEvent
{
    /**
     * @var mixed
     */
    protected $response = null;

    /**
     * {@inheritdoc}
     *
     * @param mixed $response
     */
    public function __construct(HttpKernelInterface $kernel, Request $request, $response)
    {
        parent::__construct($kernel, $request);
        $this->response = $response;
    }
}