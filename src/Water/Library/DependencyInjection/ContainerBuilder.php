<?php
/**
 * User: Ivan C. Sanches
 * Date: 30/09/13
 * Time: 15:33
 */
namespace Water\Library\DependencyInjection;

use Water\Library\DependencyInjection\Bag\DefinitionBag;
use Water\Library\DependencyInjection\Bag\ExtensionBag;
use Water\Library\DependencyInjection\Compiler\Compiler;
use Water\Library\DependencyInjection\Compiler\CompilerInterface;
use Water\Library\DependencyInjection\Compiler\Process\ProcessInterface;
use Water\Library\DependencyInjection\Exception\NotExistServiceException;
use Water\Library\DependencyInjection\Extension\ExtensionInterface;

/**
 * Class ContainerBuilder
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ContainerBuilder extends Container implements ContainerBuilderInterface
{
    /**
     * @var ExtensionBag
     */
    protected $extensions = null;

    /**
     * @var DefinitionBag
     */
    protected $definitions = null;

    /**
     * @var CompilerInterface
     */
    protected $compileProcessor = null;

    /**
     * @var bool
     */
    protected $compiled = false;

    /**
     * {@inheritdoc}
     */
    public function __construct(array $parameters = array())
    {
        parent::__construct($parameters);

        $this->extensions  = new ExtensionBag();
        $this->definitions = new DefinitionBag();
    }

    /**
     * {@inheritdoc}
     */
    public function register($id, $class, array $args = array())
    {
        $this->compiled = false;
        $this->addDefinition($id, $definition = new Definition($class, $args));
        return $definition;
    }

    /**
     * {@inheritdoc}
     */
    public function hasDefinition($id)
    {
        return $this->definitions->has($id);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefinitions(array $definitions)
    {
        $this->compiled = false;
        return $this->definitions->fromArray($definitions);
    }

    /**
     * {@inheritdoc}
     */
    public function addDefinition($id, Definition $definition)
    {
        $this->compiled = false;
        $this->definitions->set($id, $definition);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefinitions()
    {
        return $this->definitions;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefinitionsByTag($tag)
    {
        $bag = new DefinitionBag();
        foreach ($this->getDefinitions() as $id => $definition) {
            if ($definition->hasTag($tag)) {
                $bag->set($id, $definition);
            }
        }
        return $bag;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefinition($id)
    {
        return $this->definitions->get($id);
    }

    /**
     * {@inheritdoc}
     */
    public function registerExtension($id, ExtensionInterface $extension)
    {
        $this->compiled = false;
        $this->addExtension($id, $extension);
        return $extension;
    }

    /**
     * {@inheritdoc}
     */
    public function hasExtension($id)
    {
        return $this->extensions->has($id);
    }

    /**
     * {@inheritdoc}
     */
    public function removeExtension($id)
    {
        $this->compiled = false;
        $this->extensions->remove($id);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setExtensions(array $extensions)
    {
        $this->compiled = false;
        return $this->extensions->fromArray($extensions);
    }

    /**
     * {@inheritdoc}
     */
    public function addExtension($id, ExtensionInterface $extension)
    {
        $this->compiled = false;
        $this->extensions->set($id, $extension);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getExtensions()
    {
        return $this->extensions;
    }

    /**
     * {@inheritdoc}
     */
    public function getExtension($id)
    {
        return $this->extensions->get($id);
    }

    /**
     * {@inheritdoc}
     */
    public function setCompiler(CompilerInterface $compileProcessor)
    {
        $this->compiled = false;
        $this->compileProcessor = $compileProcessor;
    }

    /**
     * {@inheritdoc}
     */
    public function getCompiler()
    {
        if ($this->compileProcessor === null) {
            $this->compileProcessor = new Compiler();
        }
        return $this->compileProcessor;
    }

    /**
     * {@inheritdoc}
     */
    public function addProcess(ProcessInterface $process)
    {
        $this->compiled = false;
        $this->getCompiler()->addProcess($process);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function compile()
    {
        if (!$this->isCompiled()) {
            $this->getCompiler()->compile($this);
            $this->compiled = true;
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isCompiled()
    {
        return $this->compiled;
    }

    public function has($id)
    {
        if ($this->services->has($id) || $this->definitions->has($id)) {
            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function get($id)
    {
        if ($this->services->has($id)) {
            return $this->services->get($id);
        }

        return $this->createService($id);
    }

    /**
     * Create a service using the definitions.
     *
     * @param string $id
     * @return mixed
     *
     * @throws NotExistServiceException
     * @throws \InvalidArgumentException
     * @throws \ReflectionException
     */
    private function createService($id)
    {
        if (DefinitionBag::DEFAULT_VALUE === $definition = $this->getDefinition($id)) {
            throw new NotExistServiceException(sprintf(
                'Not exist service with id "%s".',
                $id
            ));
        }

        $class = $definition->getClass();
        if (false !== $index = $this->parameters->resolve($class)) {
            $class = $this->getParameter($index);
        }

        if (!class_exists($class, true)) {
            throw new \InvalidArgumentException(sprintf(
                'Not exist class "%s" definition in service id "%s"',
                $class,
                $id
            ));
        }

        if (!$definition->hasFactoryClass()) {
            $service = $this->createInstantiableClass($id, $class, $definition);
        } else {
            $service = $this->createFactoryClass($id, $class, $definition);
        }

        if ($definition->hasMethodsCall()) {
            foreach ($definition->getMethodsCall() as $value) {
                $method    = $value[0];
                $arguments = $value[1];
                $arguments = $this->prepareArguments($arguments, $id, $definition->getClass());

                call_user_func_array(array($service, $method), $arguments);
            }
        }

        $this->add($id, $service);
        return $service;
    }

    /**
     * @param string     $id
     * @param string     $class
     * @param Definition $definition
     * @return object
     *
     * @throws \InvalidArgumentException
     *
     */
    private function createInstantiableClass($id, $class, Definition $definition)
    {
        $reflectionClass  = new \ReflectionClass($class);
        if (null === $reflectionMethod = $reflectionClass->getConstructor()) {
            $service = $reflectionClass->newInstance();
        } else {
            if ($reflectionMethod->getNumberOfRequiredParameters() > count($arguments = $definition->getArguments())) {
                throw new \InvalidArgumentException(sprintf(
                    'Insufficient arguments to instance the service "%s" specified by id "%s"',
                    $class,
                    $id
                ));
            }
            $arguments = $this->prepareArguments($arguments, $id, $class);
            $service   = $reflectionClass->newInstanceArgs($arguments);
        }

        return $service;
    }

    /**
     * @param string     $id
     * @param string     $class
     * @param Definition $definition
     * @return object
     *
     * @throws \InvalidArgumentException
     */
    private function createFactoryClass($id, $class, Definition $definition)
    {
        $factoryClass  = $definition->getFactoryClass();
        $factoryMethod = $definition->getFactoryMethod();

        if (false !== $index = $this->parameters->resolve($factoryClass)) {
            $factoryClass = $this->getParameter($index);
        }

        if (false !== $index = $this->parameters->resolve($factoryMethod)) {
            $factoryMethod = $this->getParameter($index);
        }

        if (!class_exists($factoryClass, true) || !method_exists($factoryClass, $factoryMethod)) {
            throw new \InvalidArgumentException(sprintf(
                'Not exist factory "%s::%s()" defined in service id "%s"',
                $factoryClass,
                $factoryMethod,
                $id
            ));
        }

        $reflectionClass = new \ReflectionClass($factoryClass);
        $reflectionMethod = $reflectionClass->getMethod($factoryMethod);

        if (!$reflectionMethod->isStatic()){
            throw new \InvalidArgumentException(sprintf(
                'The factory method have to be static function. ("%s::%s()" defined in service id "%s" given)',
                $factoryClass,
                $factoryMethod,
                $id
            ));
        }

        $arguments = $this->prepareArguments($definition->getArguments(), $id, $class);
        $service   = call_user_func_array(array($factoryClass, $factoryMethod), $arguments);

        if (!is_a($service, $class)) {
            throw new \InvalidArgumentException(sprintf(
                'The service id "%s" return by factory "%s::%s()", do not return a specified service "%s".',
                $id,
                $factoryClass,
                $factoryMethod,
                $class
            ));
        }

        return $service;
    }

    /**
     * Prepare the arguments to be passed to a method.
     *
     * @param array  $arguments
     * @param string $id
     * @param string $class
     * @return array
     *
     * @throws \InvalidArgumentException
     */
    private function prepareArguments(array $arguments, $id, $class)
    {
        $args = array();
        foreach ($arguments as $value) {
            if (false !== $index = $this->parameters->resolve($value)) {
                if ($this->parameters->has($index)) {
                    $args[] = $this->getParameter($index);
                    continue;
                }

                throw new \InvalidArgumentException(sprintf(
                    'Not found parameter index "%s". It was used in the service id "%s", '
                    . 'when try to instance the class "%s"',
                    $index,
                    $id,
                    $class
                ));
            }

            if (false !== $index = $this->services->resolve($value)) {
                if ($this->has($index)) {
                    $args[] = $this->get($index);
                    continue;
                }

                throw new \InvalidArgumentException(sprintf(
                    'Not found service id "%s". It was used as a argument in the service id "%s", '
                    . 'when try to instance the class "%s"',
                    $index,
                    $id,
                    $class
                ));
            }

            $args[] = $value;
        }
        return $args;
    }
}