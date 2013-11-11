<?php
/**
 * User: Ivan C. Sanches
 * Date: 11/11/13
 * Time: 14:06
 */
namespace Water\Module\TeapotModule\DependencyInjection\Compiler\Process;

use Water\Framework\Kernel\Module\ModuleInterface;
use Water\Library\DependencyInjection\Compiler\Process\ProcessInterface;
use Water\Library\DependencyInjection\Extension\ExtensionInterface;
use Water\Library\DependencyInjection\ContainerBuilderInterface;

/**
 * Class RegisterHelpersProcess
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class RegisterHelpersProcess implements ProcessInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilderInterface $container)
    {
        $modules        = $container->get('modules');
        $templateHelper = $container->get('template.helper');
        foreach ($modules as $module) {
            $helperExtension = $this->getHelperExtension($module);

            if ($helperExtension === null) {
                break;
            }

            if (is_a($helperExtension, '\Water\Library\DependencyInjection\ContainerAware')) {
                $helperExtension->setContainer($container);
            }

            $templateHelper->addExtension($helperExtension);
        }
    }

    /**
     * @param ModuleInterface $module
     * @return ExtensionInterface|null
     */
    private function getHelperExtension(ModuleInterface $module)
    {
        $class = $module->getNamespaceName() . '\Teapot\HelperExtension';
        if (
            class_exists($class, true)
            && is_a($extension = new $class(), '\Water\Library\DependencyInjection\Extension\ExtensionInterface')
        ) {
            return $extension;
        }
        return null;
    }
}