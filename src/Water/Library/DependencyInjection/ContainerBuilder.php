<?php
/**
 * User: Ivan C. Sanches
 * Date: 28/09/13
 * Time: 21:18
 */
namespace Water\Library\DependencyInjection;

use Water\Library\DependencyInjection\Exception\InvalidArgumentException;

/**
 * Class ContainerBuilder
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ContainerBuilder extends Container
{
    const PARAMETER_REGEX = '/^%([a-zA-Z0-9_.-]+)%$/';
    const SERVICE_REGEX   = '/^#([a-zA-Z0-9_.-]+)$/';

    /**
     * @var array
     */
    private $servicesDefinitions = array();

    /**
     * @var bool
     */
    private $compiled = false;

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param string $id
     * @param string $service
     * @param array  $args
     * @return ServiceDefinition
     */
    public function register($id, $service, array $args = array())
    {
        return $this->setServiceDefinition($id, new ServiceDefinition($service, $args));
    }

    /**
     * @param string $id
     * @return bool
     */
    public function hasServiceDefinition($id)
    {
        return isset($this->servicesDefinitions[$id]);
    }

    /**
     * @param string $id
     * @return ServiceDefinition|null
     */
    public function getServiceDefinition($id)
    {
        return ($this->hasServiceDefinition($id)) ? $this->servicesDefinitions[$id] : null;
    }

    /**
     * @param string            $id
     * @param ServiceDefinition $serviceDefinition
     * @return ServiceDefinition
     */
    public function setServiceDefinition($id, ServiceDefinition $serviceDefinition)
    {
        $this->compiled = false;

        unset($this->servicesDefinitions[$id]);
        $this->servicesDefinitions[$id] = $serviceDefinition;
        return $serviceDefinition;
    }

    /**
     * {@inheritdoc}
     */
    public function get($id)
    {
        if ($this->compiled === false) {
            $this->compile();
        }
        return parent::get($id);
    }

    /**
     * Return a array with all service's ids that have the specified tag name.
     *
     * @param string $name
     * @return array
     */
    public function getServiceIdsByTag($name)
    {
        $serviceIds = array();
        foreach ($this->servicesDefinitions as $id => $serviceDefinition) {
            if ($serviceDefinition->hasTag($name)) {
                $serviceIds[] = $id;
            }
        }
        return $serviceIds;
    }

    /**
     * Generate all services.
     */
    public function compile()
    {
        $this->services = array();
        foreach ($this->servicesDefinitions as $id => $serviceDefinition) {
            if (isset($this->services[$id])) {
                continue;
            }
            $this->createService($id, $serviceDefinition);
        }
        $this->compiled = true;
    }

    /**
     * Create a service using the ServiceDefinition information.
     *
     * @param string $id
     * @param ServiceDefinition $serviceDefinition
     * @param bool $returnService
     * @return object|void
     *
     * @throws InvalidArgumentException
     */
    private function createService($id, ServiceDefinition $serviceDefinition, $returnService = false)
    {
        if (isset($this->services[$id])) {
            return (!$returnService) ? : $this->services[$id];
        }

        if (!class_exists($class = $serviceDefinition->getClass(), true)) {
            throw new InvalidArgumentException(sprintf(
                'The service specified by id "%s", not have a exists class ("%s" given).',
                $id,
                $class
            ));
        }

        $ref     = new \ReflectionClass($class);
        $args    = $this->prepareArguments($id, $serviceDefinition, $serviceDefinition->getArguments());
        $service = $ref->newInstanceArgs($args);

        foreach ($serviceDefinition->getMethodsCall() as $methodName => $args) {
            if ($ref->hasMethod($methodName)) {
                $args = $this->prepareArguments($id, $serviceDefinition, $args);
                call_user_func_array(array($service, $methodName), $args);
            }
        }

        $this->set($id, $service);

        if ($returnService) {
            return $service;
        }
    }

    /**
     * Prepare the arguments.
     *
     * @param string            $id
     * @param ServiceDefinition $parent
     * @param array             $args
     * @return array
     *
     * @throws InvalidArgumentException
     */
    private function prepareArguments($id, ServiceDefinition $parent, array $args)
    {
        $return = array();
        foreach ($args as $arg) {
            if (preg_match(self::PARAMETER_REGEX, $arg, $matches)) {
                $arg = $this->getParameter($matches[1]);
            } elseif (preg_match(self::SERVICE_REGEX, $arg, $matches)) {
                if (!$this->hasServiceDefinition($matches[1])) {
                    throw new InvalidArgumentException(sprintf(
                        'The service specified by id "%s", not exist. It was called when trying to create "%s" specified by id "%s".',
                        $matches[1],
                        $parent->getClass(),
                        $id
                    ));
                }
                $arg = $this->createService($matches[1], $this->getServiceDefinition($matches[1]), true);
            }

            $return[] = $arg;
        }

        return $return;
    }
}