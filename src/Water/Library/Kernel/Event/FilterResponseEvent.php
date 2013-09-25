<?php
/**
 * User: Ivan C. Sanches
 * Date: 25/09/13
 * Time: 09:53
 */
namespace Water\Library\Kernel\Event;

use Water\Library\Kernel\HttpKernelInterface;
use Water\Library\Http\Request;
use Water\Library\Http\Response;

/**
 * Class FilterResponseEvent
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class FilterResponseEvent extends ResponseEvent
{
    /**
     * {@inheritdoc}
     */
    public function __construct(HttpKernelInterface $kernel, Request $request, Response $response)
    {
        $this->response = $response;
        parent::__construct($kernel, $request);
    }
}