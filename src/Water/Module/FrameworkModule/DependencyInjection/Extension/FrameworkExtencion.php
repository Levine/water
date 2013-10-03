<?php
/**
 * User: Ivan C. Sanches
 * Date: 29/09/13
 * Time: 13:56
 */
namespace Water\Module\FrameworkModule\DependencyInjection\Extension;

use Water\Library\DependencyInjection\ContainerBuilder;
use Water\Library\DependencyInjection\ContainerBuilderInterface;
use Water\Library\DependencyInjection\Extension\ExtensionInterface;

/**
 * Class FrameworkExtension
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class FrameworkExtension implements ExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function extend(ContainerBuilderInterface $container)
    {
        $container->register('resolver', '\Water\Module\FrameworkModule\Resolver\ControllerResolver')
                  ->addArgument('#service_container');

        $container->register('event_dispatcher', '\Water\Library\EventDispatcher\EventDispatcher');
    }
}