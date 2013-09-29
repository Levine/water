<?php
/**
 * User: Ivan C. Sanches
 * Date: 29/09/13
 * Time: 13:40
 */
namespace Water\Library\DependencyInjection;

use Water\Library\DependencyInjection\Bag\ParameterBag;
use Water\Library\DependencyInjection\Exception\NotAllowOverrideException;

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
     * @param string $id
     * @param mixed  $value
     * @return Container
     */
    public function addParameter($id, $value);

    /**
     * @param array $array
     * @return Container
     */
    public function setParameters(array $array);

    /**
     * @param string $id
     * @return mixed|null
     */
    public function getParameter($id);

    /**
     * @return ParameterBag
     */
    public function getParameters();

    /**
     * @param string $id
     * @return bool
     */
    public function has($id);

    /**
     * @param $id
     * @return null|mixed
     */
    public function get($id);

    /**
     * Define one service specified by id.
     *
     * @param string $id
     * @param mixed $service
     * @return Container
     *
     * @throws NotAllowOverrideException
     */
    public function set($id, $service);
}