<?php
/**
 * User: Ivan C. Sanches
 * Date: 30/09/13
 * Time: 15:33
 */
namespace Water\Library\DependencyInjection;

use Water\Library\DependencyInjection\Bag\DefinitionBag;
use Water\Library\DependencyInjection\Bag\ServiceBag;
use Water\Library\DependencyInjection\Compiler\Compiler;
use Water\Library\DependencyInjection\Compiler\CompilerInterface;
use Water\Library\DependencyInjection\Compiler\Process\ProcessInterface;

/**
 * Class ContainerBuilder
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ContainerBuilder extends Container implements ContainerBuilderInterface
{
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

        $this->definitions = new DefinitionBag();
    }

    /**
     * {@inheritdoc}
     */
    public function register($id, $class, array $args = array())
    {
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
        return $this->definitions->fromArray($definitions);
    }

    /**
     * {@inheritdoc}
     */
    public function addDefinition($id, Definition $definition)
    {
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
    public function getDefinition($id)
    {
        return $this->definitions->get($id);
    }

    /**
     * {@inheritdoc}
     */
    public function setCompiler(CompilerInterface $compileProcessor)
    {
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
        $this->getCompiler()->addProcess($process);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function compile()
    {
        $this->getCompiler()->compile($this);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getService($id)
    {
        if (ServiceBag::DEFAULT_VALUE !== $service = $this->getService($id)) {
            return $service;
        }

        return $this->createService($id);
    }

    /**
     * Create a service using the definitions.
     *
     * @param string $id
     * @return mixed
     */
    private function createService($id)
    {
        if (DefinitionBag::DEFAULT_VALUE === $definition = $this->getDefinition($id)) {
            // TODO throw exception not found service definition.
        }

        if (!class_exists($class = $definition->getClass(), true)) {
            // TODO throw exception wrong class definition (not exist).
        }

        try {
            $arguments       = $definition->getArguments();
            $reflectionClass = new \ReflectionClass($class);
            $service         = $reflectionClass->newInstanceArgs($arguments);

            // TODO make de methods call, resolve parameters and referenced services.

        } catch (\ReflectionException $e) {
            // TODO handle exception.
        }

        $this->setServices($id, $service);
        return $service;
    }
}