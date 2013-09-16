<?php
/**
 * User: Ivan C. Sanches
 * Date: 16/09/13
 * Time: 13:22
 */
namespace Water\Library\ServiceManager;

/**
 * Interface FactoryInterface
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
interface FactoryInterface
{
    /**
     * Create a service instance.
     *
     * @param ServiceLocatorInterface $sm
     * @return mixed
     */
    public static function create(ServiceLocatorInterface $sm = null);
}