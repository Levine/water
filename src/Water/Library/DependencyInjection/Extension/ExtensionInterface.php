<?php
/**
 * User: Ivan C. Sanches
 * Date: 02/10/13
 * Time: 11:00
 */
namespace Water\Library\DependencyInjection\Extension;

use Water\Library\DependencyInjection\ContainerBuilderInterface;

/**
 * Interface ExtensionInterface
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
interface ExtensionInterface
{
    /**
     * Extend the current container builder.
     *
     * @param ContainerBuilderInterface $container
     */
    public function extend(ContainerBuilderInterface $container);
}