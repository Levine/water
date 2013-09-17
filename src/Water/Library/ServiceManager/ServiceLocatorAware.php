<?php
/**
 * User: Ivan C. Sanches
 * Date: 17/09/13
 * Time: 15:15
 */
namespace Water\Library\ServiceManager;

/**
 * Class ServiceLocatorAware
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
abstract class ServiceLocatorAware implements ServiceLocatorAwareInterface
{
    /**
     * @var ServiceLocatorInterface
     */
    protected $container = null;

    /**
     * {@inheritdoc}
     */
    public function setServiceLocator(ServiceLocatorInterface $sm)
    {
        $this->container = $sm;
    }
}