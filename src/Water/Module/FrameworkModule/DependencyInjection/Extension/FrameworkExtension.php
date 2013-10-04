<?php
/**
 * User: Ivan C. Sanches
 * Date: 29/09/13
 * Time: 13:56
 */
namespace Water\Module\FrameworkModule\DependencyInjection\Extension;

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
                  ->setArguments(array('#service_container'));

        $container->register('dispatcher', '\Water\Library\EventDispatcher\EventDispatcher');

        $container->register('router', 'Water\Module\FrameworkModule\Router\Router')
                  ->setArguments(array('#service_container', null, array()));

        $container->register('router.listener', '\Water\Library\Kernel\EventListener\RouterListener')
                  ->setArguments(array('#router'))
                  ->addTag('kernel.dispatcher_subscriber');

        $container->register('response.listener', '\Water\Library\Kernel\EventListener\ResponseListener')
                  ->setArguments(array('UTF-8'))
                  ->addTag('kernel.dispatcher_subscriber');

        $container->register('http_kernel', '\Water\Library\Kernel\HttpKernel')
                  ->setArguments(array('#dispatcher', '#resolver'));
    }
}