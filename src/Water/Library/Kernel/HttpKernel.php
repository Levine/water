<?php
/**
 * User: Ivan C. Sanches
 * Date: 17/09/13
 * Time: 08:11
 */
namespace Water\Library\Kernel;

use Water\Library\EventDispatcher\EventDispatcher;
use Water\Library\Http\Response;
use Water\Library\Http\Request;
use Water\Library\Kernel\Event\ResponseEvent;
use Water\Library\Kernel\Event\ResponseForControllerEvent;
use Water\Library\Kernel\Exception\ControllerNotFoundException;
use Water\Library\Kernel\Exception\LogicException;
use Water\Library\Kernel\Resolver\ControllerResolverInterface;

/**
 * Class HttpKernel
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class HttpKernel implements HttpKernelInterface, ServiceLocatorAwareInterface
{
    /**
     * @var EventDispatcher
     */
    protected $dispatcher = null;

    /**
     * @var ControllerResolverInterface
     */
    protected $resolver = null;

    /**
     * Constructor.
     */
    public function __construct(EventDispatcher $dispatcher, ControllerResolverInterface $resolver)
    {
        $this->dispatcher = $dispatcher;
        $this->resolver   = $resolver;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Request $request)
    {
        try {
            return $this->handleRequest($request);
        } catch (\Exception $e) {
            $response = $this->handleException($e);
            if ($response === null) {
                return $e;
            }
            return $response;
        }
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @throws ControllerNotFoundException
     * @throws LogicException
     */
    protected function handleRequest(Request $request)
    {
        $event = new ResponseEvent($this, $request);
        $this->dispatcher->dispatch(KernelEvents::REQUEST, $event);

        if ($event->hasResponse()) {
            return $event->getResponse();
        }

        if (false === $controller = $this->resolver->getController($request)) {
            throw new ControllerNotFoundException(sprintf('Not found controller for path "%s".', $request->getPath()));
        }

        $response = call_user_func_array($controller, $this->resolver->getArguments($request));

        if (!$response instanceof Response) {
            $event = new ResponseForControllerEvent($this, $request, $response);
            $this->dispatcher->dispatch(KernelEvents::VIEW, $event);

            if (!$event->hasResponse()) {
                throw new LogicException(sprintf(
                    'Controller must return "array" or "Response" (%s given).',
                    (is_object($response)) ? get_class($response) : gettype($response)
                ));
            }

            $response = $event->getResponse();
        }

        return $response;
    }

    /**
     * Handle every exception.
     *
     * @param \Exception $e
     * @return Response|\Exception
     */
    protected function handleException(\Exception $e)
    {
    }
}