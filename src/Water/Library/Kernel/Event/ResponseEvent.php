<?php
/**
 * User: Ivan C. Sanches
 * Date: 22/09/13
 * Time: 21:34
 */
namespace Water\Library\Kernel\Event;

use Water\Library\Http\Response;

/**
 * Class ResponseEvent
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ResponseEvent extends KernelEvent
{
    /**
     * @var Response
     */
    protected $response = null;

    public function hasResponse()
    {
        if ($this->response !== null && ($this->response instanceof Response)) {
            return true;
        }
        return false;
    }

    // @codeCoverageIgnoreStart
    /**
     * @param Response $response
     * @return ResponseEvent
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;
        return $this;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }
    // @codeCoverageIgnoreEnd
}