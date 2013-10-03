<?php
/**
 * User: Ivan C. Sanches
 * Date: 26/09/13
 * Time: 15:35
 */
namespace Water\Module\FrameworkModule;

use Water\Framework\Kernel\Module\Module;
use Water\Library\DependencyInjection\ContainerBuilderInterface;
use Water\Module\FrameworkModule\DependencyInjection\Compiler\Process\EventDispatcherTaggedProcess;

/**
 * Class FrameworkModule
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class FrameworkModule extends Module
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilderInterface $container)
    {
        $container->addProcess(new EventDispatcherTaggedProcess());

        parent::build($container);
    }
}