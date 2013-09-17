<?php
/**
 * User: Ivan C. Sanches
 * Date: 16/09/13
 * Time: 13:22
 */
namespace Water\Library\ServiceManager;

use Water\Library\ServiceManager\Exception\ServiceNotFoundException;
use Water\Library\ServiceManager\Exception\ServiceOverrideDisabledException;

/**
 * Interface ServiceLocatorInterface
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
interface ServiceLocatorInterface
{
    /**
     * @param string $index
     * @param mixed  $value
     * @return ServiceManager
     *
     * @throws ServiceOverrideDisabledException
     */
    public function set($index, $value);

    /**
     * Returns if the specified service exists.
     *
     * @param string $name
     * @return bool
     */
    public function has($name);

    /**
     * Returns a specified service.
     *
     * @param string $name
     * @param array  $options
     * @return mixed
     *
     * @throws ServiceNotFoundException
     */
    public function get($name, array $options = array());
}