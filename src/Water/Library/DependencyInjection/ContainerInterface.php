<?php
/**
 * User: Ivan C. Sanches
 * Date: 29/09/13
 * Time: 13:40
 */
namespace Water\Library\DependencyInjection;

use Water\Library\DependencyInjection\Bag\ParameterBag;
use Water\Library\DependencyInjection\Bag\ServiceBag;

/**
 * Interface ContainerInterface
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
interface ContainerInterface
{
    /**
     * @param string $id
     * @return bool
     */
    public function hasParameter($id);

    /**
     * @param array $parameters
     * @return array
     */
    public function setParameters(array $parameters);

    /**
     * @param string $id
     * @param mixed  $value
     * @return ContainerInterface
     */
    public function addParameter($id, $value);

    /**
     * @return ParameterBag
     */
    public function getParameters();

    /**
     * @param string $id
     * @return mixed|null
     */
    public function getParameter($id);

    /**
     * @param string $id
     * @return bool
     */
    public function hasService($id);

    /**
     * @param array $services
     * @return array
     */
    public function setServices(array $services);

    /**
     * Define one service specified by id.
     *
     * @param string $id
     * @param mixed  $service
     * @return ContainerInterface
     */
    public function addService($id, $service);

    /**
     * Return all services.
     *
     * @return ServiceBag
     */
    public function getServices();

    /**
     * @param $id
     * @return mixed|null
     */
    public function getService($id);
}