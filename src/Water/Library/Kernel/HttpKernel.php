<?php
/**
 * User: Ivan C. Sanches
 * Date: 17/09/13
 * Time: 08:11
 */
namespace Water\Library\Kernel;

use Water\Library\Http\Response;
use Water\Library\Http\Request;
use Water\Library\Kernel\Service\ServiceManagerConfig;
use Water\Library\ServiceManager\ServiceLocatorAwareInterface;
use Water\Library\ServiceManager\ServiceLocatorInterface;
use Water\Library\ServiceManager\ServiceManager;

/**
 * Class HttpKernel
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class HttpKernel implements HttpKernelInterface, ServiceLocatorAwareInterface
{
    /**
     * @var ServiceManager
     */
    protected $container = null;

    /**
     * Constructor.
     */
    public function __construct(ServiceLocatorInterface $sm = null, array $config = array())
    {
        $this->container = ($sm !== null) ? $sm : new ServiceManager(new ServiceManagerConfig($config));
        $this->container->set('appConfig', $config);
        $this->container->enableOverride();
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Request $request)
    {
        try {
            return $this->handleRequest($request);
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * @param Request $request
     * @return Response
     */
    protected function handleRequest(Request $request)
    {
        $this->container->set('request', $request);

        if (!$request->getResource()->has('_controller')) {
            $this->container->get('router');
        }

        $resolver = $this->container->get('resolver');

        $controller = $resolver->getController($request);
        $args       = $resolver->getArguments($request);

        $response = call_user_func_array($controller, $args);

        if ($response instanceof Response) {
            $this->container->set('response', $response);
        } else {
            // TODO - Render view with response parameters.
        }

        return $response;
    }

    /**
     * Handle every exception.
     *
     * @param \Exception $e
     * @return Response
     */
    protected function handleException(\Exception $e)
    {
        $appConfig = $this->container->get('appConfig');

        if (isset($appConfig['framework']['error_handler'])) {
            $request = Request::create(
                null,
                null,
                array(),
                array(
                    '_controller' => $appConfig['framework']['error_handler'],
                    '_args'       => array($e),
                )
            );

            try {
                $response = $this->handleRequest($request);
                $response->setStatusCode(500);
            } catch (\Exception $e) {
                $response = Response::create(
                    sprintf('Exception thrown when handling an exception (%s: %s)', get_class($e), $e->getMessage()),
                    500
                );
            }

            return $response;
        }
    }

    // @codeCoverageIgnoreStart
    /**
     * {@inheritdoc}
     */
    public function setServiceLocator(ServiceLocatorInterface $sm)
    {
        $this->container = $sm;
    }
    // @codeCoverageIgnoreEnd
}