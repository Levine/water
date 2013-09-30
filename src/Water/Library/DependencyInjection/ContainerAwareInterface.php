<?php
/**
 * User: Ivan C. Sanches
 * Date: 30/09/13
 * Time: 15:26
 */
namespace Water\Library\DependencyInjection;

/**
 * Interface ContainerAwareInterface
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
interface ContainerAwareInterface
{
    /**
     * @param ContainerInterface $container
     * @return ContainerAwareInterface
     */
    public function setContainer(ContainerInterface $container);
}