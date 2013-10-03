<?php
/**
 * User: Ivan C. Sanches
 * Date: 02/10/13
 * Time: 22:23
 */
namespace Water\Module\FrameworkModule\DependencyInjection\Compiler\Process;

use Water\Library\DependencyInjection\Compiler\Process\ProcessInterface;
use Water\Library\DependencyInjection\ContainerBuilderInterface;

/**
 * Class EventDispatcherTaggedProcess
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class EventDispatcherTaggedProcess implements ProcessInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilderInterface $container)
    {
        if (!$container->has('dispatcher')) {
            return;
        }

        $dispatcherDefinition = $container->getDefinition('dispatcher');
        foreach ($container->getDefinitionsByTag('kernel.dispatcher_subscriber') as $serviceId => $definition) {
            $dispatcherDefinition->addMethodCall('addSubscriber', array("#{$serviceId}"));
        }
    }
}