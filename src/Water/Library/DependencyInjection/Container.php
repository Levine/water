<?php
/**
 * User: Ivan C. Sanches
 * Date: 30/09/13
 * Time: 14:30
 */
namespace Water\Library\DependencyInjection;

use Water\Library\DependencyInjection\Bag\ParameterBag;
use Water\Library\DependencyInjection\Bag\ServiceBag;
use Water\Library\DependencyInjection\Exception\NotExistParameterException;
use Water\Library\DependencyInjection\Exception\NotExistServiceException;

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
     * @var ServiceBag
     */
    protected $services = null;

    /**
     * Constructor.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters = array())
    {
        $this->parameters = new ParameterBag($parameters);
        $this->services   = new ServiceBag();

        $this->add('service_container', $this);
    }

    /**
     * {@inheritdoc}
     */
    public function hasParameter($id)
    {
        return $this->parameters->has($id);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public function setParameters(array $parameters)
    {
        return $this->parameters->fromArray($parameters);
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
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function getParameter($id)
    {
        if ($this->parameters->has($id)) {
            return $this->parameters->get($id);
        }

        throw new NotExistParameterException(sprintf(
            'Not exist parameter with id "%s".',
            $id
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function has($id)
    {
        return $this->services->has($id);
    }

    /**
     * {@inheritdoc}
     */
    public function setServices(array $services)
    {
        return $this->services->fromArray($services);
    }

    /**
     * {@inheritdoc}
     */
    public function add($id, $service)
    {
        $this->services->set($id, $service);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * {@inheritdoc}
     */
    public function get($id)
    {
        if ($this->services->has($id)) {
            return $this->services->get($id);
        }

        throw new NotExistServiceException(sprintf(
            'Not exist service with id "%s".',
            $id
        ));
    }
}