<?php
/**
 * User: Ivan C. Sanches
 * Date: 29/09/13
 * Time: 13:39
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
     * Define container.
     *
     * @param ContainerInterface $container
     * @return ContainerAwareInterface
     */
    public function setContainer(ContainerInterface $container);
}