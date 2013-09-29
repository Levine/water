<?php
/**
 * User: Ivan C. Sanches
 * Date: 27/09/13
 * Time: 15:51
 */
namespace Water\Library\DependencyInjection;

use Water\Library\DependencyInjection\Bag\ParameterBag;
use Water\Library\DependencyInjection\Exception\NotAllowOverrideException;

/**
 * Class Container
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class Container
{
    /**
     * @var ParameterBag
     */
    protected $parameters = null;

    /**
     * @var array
     */
    protected $services = array();

    /**
     * @var bool
     */
    protected $allowOverride = false;

    /**
     * Constructor.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters = array())
    {
        $this->parameters    = new ParameterBag($parameters);
        $this->allowOverride = false;

        $this->set('service_container', $this);
    }

    /**
     * @param string $id
     * @return bool
     */
    public function hasParameter($id)
    {
        return isset($this->parameters[$id]);
    }

    /**
     * @param string $id
     * @param mixed  $value
     * @return Container
     */
    public function addParameter($id, $value)
    {
        $this->parameters->set($id, $value);
        return $this;
    }

    /**
     * @param array $array
     * @return Container
     */
    public function setParameters(array $array)
    {
        $this->parameters->fromArray($array);
        return $this;
    }

    /**
     * @param string $id
     * @return mixed|null
     */
    public function getParameter($id)
    {
        return $this->parameters->get($id, ParameterBag::DEFAULT_VALUE);
    }

    /**
     * @return ParameterBag
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param string $id
     * @return bool
     */
    public function has($id)
    {
        return (isset($this->services[$id]));
    }

    /**
     * @param $id
     * @return null|mixed
     */
    public function get($id)
    {
        if (isset($this->services[$id])) {
            return $this->services[$id];
        }
        return null;
    }

    /**
     * Define one service specified by id.
     *
     * @param string $id
     * @param mixed $service
     * @return Container
     *
     * @throws NotAllowOverrideException
     */
    public function set($id, $service)
    {
        if (isset($this->services[$id]) && !$this->allowOverride) {
            throw new NotAllowOverrideException(sprintf(
                'The service id "%s" is already being used by other service.',
                $id
            ));
        }
        $this->services[$id] = $service;
        return $this;
    }
}