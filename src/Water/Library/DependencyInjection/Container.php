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
class Container implements ContainerInterface
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
     * {@inheritdoc}
     */
    public function hasParameter($id)
    {
        return isset($this->parameters[$id]);
    }

    /**
     * {@inheritdoc}
     */
    public function addParameter($id, $value)
    {
        $this->parameters->set($id, $value);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setParameters(array $array)
    {
        $this->parameters->fromArray($array);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getParameter($id)
    {
        return $this->parameters->get($id, ParameterBag::DEFAULT_VALUE);
    }

    /**
     * {@inheritdoc}
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function has($id)
    {
        return (isset($this->services[$id]));
    }

    /**
     * {@inheritdoc}
     */
    public function get($id)
    {
        if (isset($this->services[$id])) {
            return $this->services[$id];
        }
        return null;
    }

    /**
     * {@inheritdoc}
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