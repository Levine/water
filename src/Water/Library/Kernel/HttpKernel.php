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
use Water\Library\Kernel\Event\FilterResponseEvent;
use Water\Library\Kernel\Event\ResponseEvent;
use Water\Library\Kernel\Event\ResponseFromControllerEvent;
use Water\Library\Kernel\Event\ResponseFromExceptionEvent;
use Water\Library\Kernel\Exception\ControllerNotFoundException;
use Water\Library\Kernel\Exception\LogicException;
use Water\Library\Kernel\Controller\ControllerResolverInterface;

/**
 * Class HttpKernel
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class HttpKernel implements HttpKernelInterface
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
    public function handle(Request $request, $catch = true)
    {
        try {
            return $this->handleRequest($request);
        } catch (\Exception $exception) {
            if ($catch === false) {
                throw $exception;
            }
            return $this->handleException($request, $exception);
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
            $event = new ResponseFromControllerEvent($this, $request, $response);
            $this->dispatcher->dispatch(KernelEvents::VIEW, $event);

            if (!$event->hasResponse()) {
                throw new LogicException('The controller return can not be converted in Response.');
            }

            $response = $event->getResponse();
        }

        return $this->filterResponse($request, $response);
    }

    /**
     * Handle every exception.
     *
     * @param Request    $request
     * @param \Exception $exception
     * @return Response
     */
    protected function handleException(Request $request, \Exception $exception)
    {
        $event = new ResponseFromExceptionEvent($this, $request, $exception);
        $this->dispatcher->dispatch(KernelEvents::EXCEPTION, $event);

        if ($event->hasResponse()) {
            return $this->filterResponse($request, $event->getResponse());
        }
        return $this->filterResponse($request, Response::create('Internal Server Error.', 500));
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function filterResponse(Request $request, Response $response)
    {
        $event = new FilterResponseEvent($this, $request, $response);
        $this->dispatcher->dispatch(KernelEvents::RESPONSE, $event);

        return $event->getResponse();
    }

    // @codeCoverageIgnoreStart
    /**
     * @return \Water\Library\EventDispatcher\EventDispatcher
     */
    public function getDispatcher()
    {
        return $this->dispatcher;
    }

    /**
     * @return \Water\Library\Kernel\Controller\ControllerResolverInterface
     */
    public function getResolver()
    {
        return $this->resolver;
    }
    // @codeCoverageIgnoreEnd
}