<?php
/**
 * User: Ivan C. Sanches
 * Date: 17/09/13
 * Time: 09:02
 */
namespace Water\Library\Kernel\Service;

use Water\Library\ServiceManager\ServiceManager;
use Water\Library\ServiceManager\ServiceManagerConfigInterface;

/**
 * Class ServiceManagerConfig
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ServiceManagerConfig implements ServiceManagerConfigInterface
{
    /**
     * @var array
     */
    private $factories = array(
        'resolver'      => '\Water\Library\Kernel\Service\ControllerResolverFactory',
        'router'        => '\Water\Library\Kernel\Service\RouterFactory',
    );

    /**
     * @var array
     */
    private $instantiables = array();

    /**
     * @var array
     */
    private $alias = array();

    /**
     * Constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = array())
    {
        if (isset($config['service_manager']['factories'])) {
            $this->factories = array_merge($this->factories, (array) $config['service_manager']['factories']);
        }

        if (isset($config['service_manager']['instanciables'])) {
            $this->instantiables = array_merge($this->instantiables, (array) $config['service_manager']['instanciables']);
        }

        if (isset($config['service_manager']['alias'])) {
            $this->alias = array_merge($this->alias, (array) $config['service_manager']['alias']);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configure(ServiceManager $sm)
    {
        $sm->setFactories($this->factories);
        $sm->setInstantiables($this->instantiables);
        $sm->setAlias($this->alias);
    }
}