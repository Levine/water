<?php
/**
 * User: Ivan C. Sanches
 * Date: 18/09/13
 * Time: 15:41
 */
namespace Water\Framework\Kernel;

use Water\Library\Kernel\HttpKernel;
use Water\Framework\Kernel\Service\ServiceManagerConfig;
use Water\Library\ServiceManager\ServiceLocatorInterface;
use Water\Library\ServiceManager\ServiceManager;

/**
 * Class Kernel
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class Kernel extends HttpKernel
{
    /**
     * {@inheritdoc}
     */
    public function __construct(ServiceLocatorInterface $sm = null, array $config = array())
    {
        $this->container = ($sm !== null) ? $sm : new ServiceManager(new ServiceManagerConfig($config));
        $this->container->set('appConfig', $config);
        $this->container->enableOverride();
    }
}