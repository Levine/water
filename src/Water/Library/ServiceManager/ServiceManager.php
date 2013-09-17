<?php
/**
 * User: Ivan C. Sanches
 * Date: 16/09/13
 * Time: 13:11
 */
namespace Water\Library\ServiceManager;

use Water\Library\Bag\SimpleBag;
use Water\Library\ServiceManager\Exception\ServiceNotFoundException;
use Water\Library\ServiceManager\Exception\ServiceOverrideDisabledException;

/**
 * Class ServiceManager
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ServiceManager implements ServiceLocatorInterface
{
    /**
     * @var bool
     */
    private $allowOverride = false;

    /**
     * @var SimpleBag
     */
    private $container = null;

    /**
     * @var array
     */
    private $factories = array();
    private $instantiables = array();

    /**
     * @var array
     */
    private $alias = array();

    public function __construct(ServiceManagerConfigInterface $config = null)
    {
        $this->container     = new SimpleBag();
        if ($config !== null) {
            $config->configure($this);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function set($index, $value)
    {
        $index = $this->getRealName($index);
        if (!($this->container->has($index)
            || $this->canCreateFactory($index)
            || $this->canCreateInstance($index))
            || $this->allowOverride
        ) {
            $this->container->set($index, $value);
            return $this;
        }

        throw new ServiceOverrideDisabledException(
            sprintf('The service "%s" already exists, and the allow override service is disable.', $index)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function has($name)
    {
        $name = $this->getRealName($name);

        if ($this->container->has($name)
            || $this->canCreateFactory($name)
            || $this->canCreateInstance($name)
        ) {
            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function get($name, array $options = array())
    {
        $name = $this->getRealName($name);

        if ($this->container->has($name)) {
            return $this->container->get($name);
        }

        $instance = false;
        if ($this->canCreateFactory($name)) {
            $instance = $this->createFactory($name);
        }

        if ($this->canCreateInstance($name)) {
            $instance = $this->createInstance($name, $options);
        }

        if ($instance) {
            $this->container->set($name, $instance);
            return $this->container->get($name);
        }

        throw new ServiceNotFoundException(
            sprintf(
                'Not found service with specified name "%s".',
                $name
            )
        );
    }

    /**
     * Return the real name from service, if has some alias.
     *
     * @param string $name
     * @return string
     */
    public function getRealName($name)
    {
        foreach ($this->alias as $key => $value) {
            if (array_search($name, (array) $value) !== false) {
                return $key;
            }
        }
        return $name;
    }

    /**
     * @param string $name
     * @return bool
     */
    private function canCreateFactory($name)
    {
        if (!isset($this->factories[$name])) {
            return false;
        }

        $factory = $this->factories[$name];
        return is_a($factory, '\Water\Library\ServiceManager\FactoryInterface', true);
    }

    /**
     * @param string $name
     * @return bool|object
     */
    private function createFactory($name)
    {
        $factory = $this->factories[$name];
        return call_user_func(array($factory, 'create'), $this);
    }

    /**
     * @param string $name
     * @return bool
     */
    private function canCreateInstance($name)
    {
        if (!isset($this->instantiables[$name])) {
            return false;
        }

        $refClass = new \ReflectionClass($this->instantiables[$name]);
        return $refClass->isInstantiable();
    }

    /**
     * @param string $name
     * @param array $options
     * @return bool|object
     */
    private function createInstance($name, array $options = array())
    {
        try {
            $refClass = new \ReflectionClass($this->instantiables[$name]);
            return $refClass->newInstanceArgs($options);
        } catch (\ReflectionException $e) {
            return false;
        }
    }

    // @codeCoverageIgnoreStart
    /**
     * @param string $name
     * @param string $factoryName
     * @return ServiceManager
     */
    public function addFactory($name, $factoryName)
    {
        unset($this->factories[$name]);
        $this->factories[$name] = $factoryName;
        return $this;
    }

    /**
     * @param string $name
     * @param string $className
     * @return ServiceManager
     */
    public function addInstantiable($name, $className)
    {
        unset($this->instantiables[$name]);
        $this->instantiables[$name] = $className;
        return $this;
    }

    /**
     * @param string       $realName
     * @param string|array $alias
     * @return ServiceManager
     */
    public function addAlias($realName, $alias)
    {
        if (!isset($this->alias[$realName])) {
            $this->alias[$realName] = (array) $alias;
        } else {
            $this->alias[$realName] = array_merge($this->alias[$realName], (array) $alias);
        }
        return $this;
    }

    /**
     * @param array $factories
     * @return ServiceManager
     */
    public function setFactories($factories)
    {
        $this->factories = $factories;
        return $this;
    }

    /**
     * @param array $instantiables
     * @return ServiceManager
     */
    public function setInstantiables($instantiables)
    {
        $this->instantiables = $instantiables;
        return $this;
    }

    /**
     * @param array $alias
     * @return ServiceManager
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
        return $this;
    }

    /**
     * @return ServiceManager
     */
    public function enableOverride()
    {
        $this->allowOverride = true;
        return $this;
    }

    /**
     * @return ServiceManager
     */
    public function disableOverride()
    {
        $this->allowOverride = false;
        return $this;
    }
    // @codeCoverageIgnoreEnd
}