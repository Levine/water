<?php
/**
 * User: Ivan C. Sanches
 * Date: 29/09/13
 * Time: 17:08
 */
namespace Water\Framework\Tests\Resource\Module\Extension;

use Water\Library\DependencyInjection\ContainerBuilder;
use Water\Library\DependencyInjection\ContainerExtensionInterface;

/**
 * Class TestExtension
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class TestExtension implements ContainerExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function extend(ContainerBuilder $container)
    {
        $container->addParameter('test', 'value');
    }
}