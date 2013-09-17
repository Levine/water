<?php
/**
 * User: Ivan C. Sanches
 * Date: 17/09/13
 * Time: 15:14
 */
namespace Water\Library\ServiceManager;

/**
 * Interface ServiceLocatorAwareInterface
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
interface ServiceLocatorAwareInterface
{
    /**
     * @param ServiceLocatorInterface $sm
     * @return mixed
     */
    public function setServiceLocator(ServiceLocatorInterface $sm);
}