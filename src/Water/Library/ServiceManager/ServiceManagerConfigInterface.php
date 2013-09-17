<?php
/**
 * User: Ivan C. Sanches
 * Date: 17/09/13
 * Time: 08:54
 */
namespace Water\Library\ServiceManager;

/**
 * Interface ServiceManagerConfigInterface
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
interface ServiceManagerConfigInterface
{
    /**
     * Configure the specified ServiceManager.
     *
     * @param ServiceManager $sm
     */
    public function configure(ServiceManager $sm);
}