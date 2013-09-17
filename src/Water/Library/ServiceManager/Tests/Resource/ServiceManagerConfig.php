<?php
/**
 * User: Ivan C. Sanches
 * Date: 17/09/13
 * Time: 08:57
 */
namespace Water\Library\ServiceManager\Tests\Resource;

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
        'serviceFactory' => '\Water\Library\ServiceManager\Tests\Resource\ServiceFactory'
    );

    /**
     * @var array
     */
    private $instantiables = array(
        'serviceInstantiable' => '\Water\Library\ServiceManager\Tests\Resource\Service'
    );

    /**
     * {@inheritdoc}
     */
    public function configure(ServiceManager $sm)
    {
        $sm->setFactories($this->factories);
        $sm->setInstantiables($this->instantiables);
    }
}