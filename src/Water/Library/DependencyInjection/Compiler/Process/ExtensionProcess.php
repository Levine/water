<?php
/**
 * User: Ivan C. Sanches
 * Date: 02/10/13
 * Time: 13:33
 */
namespace Water\Library\DependencyInjection\Compiler\Process;

use Water\Library\DependencyInjection\ContainerBuilderInterface;

/**
 * Class ExtensionProcess
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ExtensionProcess implements ProcessInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilderInterface $container)
    {
        foreach ($container->getExtensions() as $extension) {
            $extension->extend($container);
        }
    }
}