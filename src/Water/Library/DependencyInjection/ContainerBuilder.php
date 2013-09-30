<?php
/**
 * User: Ivan C. Sanches
 * Date: 30/09/13
 * Time: 15:33
 */
namespace Water\Library\DependencyInjection;

use Water\Library\DependencyInjection\Bag\DefinitionBag;
use Water\Library\DependencyInjection\CompileProcessor\CompileProcessor;
use Water\Library\DependencyInjection\CompileProcessor\CompileProcessorInterface;
use Water\Library\DependencyInjection\CompileProcessor\Process\ProcessInterface;

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
     * @var CompileProcessorInterface
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
    public function setCompileProcessor(CompileProcessorInterface $compileProcessor)
    {
        $this->compileProcessor = $compileProcessor;
    }

    /**
     * {@inheritdoc}
     */
    public function getCompileProcessor()
    {
        if ($this->compileProcessor === null) {
            $this->compileProcessor = new CompileProcessor();
        }
        return $this->compileProcessor;
    }

    /**
     * {@inheritdoc}
     */
    public function addCompileProcess(ProcessInterface $process)
    {
        $this->getCompileProcessor()->addProcess($process);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function compile()
    {

    }
}