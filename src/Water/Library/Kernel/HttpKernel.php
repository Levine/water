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
    }

    /**
     * {@inheritdoc}
     */
    public function setServiceLocator(ServiceLocatorInterface $sm)
    {
        $this->container = $sm;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Request $request)
    {
        try {
            $response = $this->handleRequest($request);
        } catch (\Exception $e) {
            $response = $this->handleException($e);
        }

        return $response;
    }

    protected function handleRequest(Request $request)
    {
        $this->container->set('request', $request);

        $this->container->get('router');

        $resolver = $this->container->get('resolver');

        $controller = $resolver->getController($request);

        $response = call_user_func_array($controller, array());

        if ($response instanceof Response) {
            $this->container->set('response', $response);
        } else {
            // TODO - Render view with response parameters.
        }

        return $response;
    }

    protected function handleException(Exception $e)
    {
        // TODO - Handle de exception.
    }
}