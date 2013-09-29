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
     * @return bool
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
    public function getServicesByTag($name)
    {
        $serviceIds = array();
        foreach ($this->servicesDefinitions as $id => $serviceDefinition) {
            if ($serviceDefinition->hasTag($name)) {
                $serviceIds[] = $id;
            }
        }
        return $serviceIds;
    }

    public function compile()
    {
        foreach ($this->servicesDefinitions as $id => $serviceDefinition) {
            $this->createService($id, $serviceDefinition);
        }
        $this->compiled = true;
    }

    private function createService($id, ServiceDefinition $serviceDefinition)
    {
        $class = $serviceDefinition->getClass();
        $args  = $serviceDefinition->getArguments();

        if (!class_exists($class, true)) {
            throw new InvalidArgumentException(sprintf(
                'The service specified by id "%s", not have a exists class ("%s" given).',
                $id,
                $class
            ));
        }

        $ref     = new \ReflectionClass($class);
        $service = $ref->newInstanceArgs($args);

        foreach ($serviceDefinition->getMethodsCall() as $methodName => $args) {
            if ($ref->hasMethod($methodName)) {
                call_user_func_array(array($service, $methodName), $args);
            }
        }

        $this->set($id, $service);
    }
}