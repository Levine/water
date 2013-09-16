<?php
/**
 * User: Ivan C. Sanches
 * Date: 16/09/13
 * Time: 15:52
 */
namespace Water\Library\ServiceManager\Tests\Resource;

use Water\Library\ServiceManager\FactoryInterface;
use Water\Library\ServiceManager\ServiceLocatorInterface;

/**
 * Class ServiceFactory
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ServiceFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public static function create(ServiceLocatorInterface $sm = null)
    {
        return new Service();
    }
}