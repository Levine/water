<?php
/**
 * User: Ivan C. Sanches
 * Date: 29/09/13
 * Time: 13:59
 */
namespace Water\Library\DependencyInjection;

/**
 * Interface ContainerExtensionInterface
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
interface ContainerExtensionInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function extend(ContainerBuilder $container);
}