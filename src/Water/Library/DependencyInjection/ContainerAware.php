<?php
/**
 * User: Ivan C. Sanches
 * Date: 29/09/13
 * Time: 13:44
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
     */
    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
        return $this;
    }
}