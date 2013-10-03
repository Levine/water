<?php
/**
 * User: Ivan C. Sanches
 * Date: 02/10/13
 * Time: 23:03
 */
namespace Water\Framework\Kernel\Tests\Module\Resource\Extension;

use Water\Library\DependencyInjection\ContainerBuilderInterface;
use Water\Library\DependencyInjection\Extension\ExtensionInterface;

/**
 * Class TestExtension
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class TestExtension implements ExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function extend(ContainerBuilderInterface $container)
    {
    }
}