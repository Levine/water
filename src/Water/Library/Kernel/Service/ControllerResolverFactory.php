<?php
/**
 * User: Ivan C. Sanches
 * Date: 17/09/13
 * Time: 09:42
 */
namespace Water\Library\Kernel\Service;

use Water\Library\Kernel\Resolver\ControllerResolver;
use Water\Library\ServiceManager\FactoryInterface;
use Water\Library\ServiceManager\ServiceLocatorInterface;

/**
 * Class ControllerResolverFactory
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ControllerResolverFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public static function create(ServiceLocatorInterface $sm = null)
    {
        return new ControllerResolver();
    }
}