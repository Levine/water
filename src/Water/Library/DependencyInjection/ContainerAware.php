<?php
/**
 * User: Ivan C. Sanches
 * Date: 30/09/13
 * Time: 15:27
 */
namespace Water\Library\DependencyInjection;

/**
 * Class ContainerAware
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
abstract class ContainerAware implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container = null;

    /**
     * {@inheritdoc}
     * @return AbstractContainerAware
     */
    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
        return $this;
    }
}